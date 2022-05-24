<?php

use JetBrains\PhpStorm\ArrayShape;

class Admin_model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->model("Currencies_model");
    }

    function get_users(): array
    {
        $users_list = $this->redis->zRevRange(self::REDIS_ALL_USERS_LIST, 0, -1);
        //rsort($users_list);
        $data = [];
        $i = 0;
//        $this->redis->zRem(self::REDIS_ALL_USERS_LIST, -1);
//        print_r($users_list); die();
        foreach ($users_list as $key => $value) {
            $user = json_decode($this->redis->hGet(self::REDIS_USER_PROFILE, $value));
            $user->organizations = $this->redis->lLen(self::REDIS_USER_ORGANIZATIONS . $value);
            $user->projects = $this->redis->lLen(self::REDIS_USER_PROJECTS_LIST . $value);
            $user->collaborations = count((array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $value)));
            $user->gender = $user->gender == 1 ? "Male" : "Female";
            $user->date_added = $user->date_added ?? NULL;
            $user->_timestamp = $user->_timestamp ?? NULL;
            $data[] = (array)$user;
        }
       return $data;
    }

    function get_organizations($limit = 15): array
    {
        $start = 0;
        $data = [];
        $organizations = $this->redis->lRange(self::REDIS_ORGANIZATIONS, $start, $limit);

        foreach ($organizations as $item) {
            $d = json_decode($this->redis->hGet(self::REDIS_ORGANIZATIONS_LIST, $item));
            $d->projects = $this->redis->lLen(self::REDIS_ORG_PROJECTS_LIST . $item);
            $data = $this->get_user_profile($d, $data);
        }
        return $data;
    }

    function get_projects($limit = 15, $start = 0): array
    {
       $projects = $this->redis->lRange(self::REDIS_PROJECTS_LIST, $start , $limit);
       $data = [];
       foreach ($projects as $value) {
           $d = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $value));
           $d->collection_tx = $this->gdb_redis->zCard(PROJECT_COLLECTIONS_TX . $value);
           $org = json_decode($this->redis->hGet(self::REDIS_ORGANIZATIONS_LIST, $this->redis->hGet(self::REDIS_PROJECT_NAMESPACE, $value)));
           $d->namespace = $org->name;
           $d->namespace_url = $org->url;
           $d->namespace_logo = $org->logo;
           $data = $this->get_user_profile($d, $data);
       }
        return $data;
    }

    /**
     * @param mixed $d
     * @param array $data
     * @return array
     */
    public function get_user_profile(mixed $d, array $data): array
    {
        $user = isset($d->username) ? json_decode($this->redis->hGet(self::REDIS_USER_PROFILE, $d->username)) : false;
//           print_r($org);
        $d->username = $user->username ?? null;
        $d->email = $user->email ?? null;
        $d->names = $user->names ?? null;
        $d->image = $user->image ?? null;
        $data[] = (array)$d;
        return $data;
    }

    function get_currency_by_country_code($code): bool|string
    {
        return $this->gdb_redis->hGet(self::COUNTRY_CURRENCY, $code);;
    }

    function get_currency_rate($base_currency) {
        return json_decode($this->gdb_redis->hGet(self::CURRENCY_RATES, $base_currency));
    }

    function _get_accepted_currencies(): array
    {
        return $this->gdb_redis->zRange(self::CURRENCIES_ACCEPTED, 0, -1);
    }

    function _fx_rates($currencies): array
    {
        $data = [];
        foreach ($currencies as $key => $currency) {
            $currency = empty(trim($currency)) ? "USD" : $currency;
            if ($currency == "USD")
                $currencies[$key] = $currency;

            for ($i = 0; $i < count($currencies); $i++) {
                $date = date("Y-m-d");
                $c = $currencies[$i];
                $data[$currency][] = $this->model->Currencies_model->get_currency_rate($currency . ":" . $date)->$c ?? 1;
            }
        }
        return $data;
    }

    function _add_accepted_currencies($currency) {
        $this->gdb_redis->zAdd(self::CURRENCIES_ACCEPTED, 1, date("Y-m-d"),
            $currency);
    }

    function _get_sms_rates(): array
    {
//        $data = $this->gdb->get("sms_rates", null, "*");
//        foreach($data as $value) {
//            unset($value['country_code']);
//            $this->gdb_redis->hSet(self::PROJECT_SMS_RATES, $value['country_code'], json_encode($value));
//        }

        $data = $this->gdb_redis->hGetAll(self::PROJECT_SMS_RATES);
        $array_data = [];
        foreach ($data as $key => $value) {
            $array_data[$key] = (array)json_decode($value);
            $array_data[$key]['currency'] = self::get_currency_by_country_code($key);
        }
        return $array_data;
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(["status" => "string", "message" => "string"])] function set_deposit_charges($user) {
        $deposit = (float)$this->inputs->post("deposit");
        $withdraw = (int)$this->inputs->post("withdraw");

        if (empty($deposit) or empty($withdraw))
            return array("status" => "error", "message" => "An error occurred");
        $data = ["deposit_charge" => $deposit, "withdraw_charge" => $withdraw, "user" => $user->user, "date_added" => date("Y-m-d")];
        $id = $this->gdb->insert("deposit_transfer_charges", $data);
        $data['id'] = $id;
        $data['username'] = $user->username;
        $this->gdb_redis->set(DEPOSIT_CHARGES, json_encode($data));
        return array("status" => "success", "message" => "Charges successfully updated");
    }

    function get_charges() {
        return json_decode($this->gdb_redis->get(DEPOSIT_CHARGES));
    }
}