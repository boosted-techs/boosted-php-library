<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 1/14/22
 * Time: 11:36 AM
 */
if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
class Sms_gateway_model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->model("Projects_model");
        $this->model("Accounts_model");
        $this->model("Organizations_model");
    }

    function    get_pending_sms($username): bool|array
    {
        $projects  = $this->model->Projects_model->get_user_projects($username);
        if (! $projects)
            return false;

        $data = [];
        foreach ($projects as $project) :
            $sms = [];
            if($project->project_type != 1)
                continue;
            $sms_transactions = $this->gdb_redis->zRange(self::PENDING_SMS_REQUESTS_KEYS . $project->url, 0, -1, "WITHSCORES");
            if (empty($sms_transactions))
                continue;

            foreach ($sms_transactions as $tx) :
                $s = json_decode($this->gdb_redis->hGet(self::PENDING_SMS_REQUESTS, $tx));
                $s->message_body = json_decode($s->message_body);
                $sms[] = $s;
            endforeach;

            $project->pending_sms = $sms;
            $data[] = $project;
        endforeach;
        return $data;
    }

    function get_sent_sms($username): bool|array
    {
        $projects  = $this->model->Projects_model->get_user_projects($username);
        if (! $projects)
            return false;

        $data = [];
        foreach ($projects as $project) :
            $sms = [];
            if($project->project_type != 1)
                continue;
            $sms_transactions = $this->gdb_redis->zRange(self::PROJECT_SMS_TX_ZSET . $project->url, 0, -1);
            if (empty($sms_transactions))
                continue;
            //print_r($sms_transactions);

            foreach ($sms_transactions as $tx) :
                $s = json_decode($this->gdb_redis->hGet(self::SMS_TX_SUCCESS, $tx));
                $stalk_response = json_decode($s->stalk_response);
                $s->stalk_response = json_decode($stalk_response);
                $sms[] = $s;
            endforeach;

            $project->sent_sms = $sms;
            $data[] = $project;
        endforeach;
        //print_r($data); die();
        return $data;
    }

    function get_sent_details($username): bool|array
    {
        $tx_ref = $this->security->xss_clean(trim($this->inputs->get("ref")));
        $project = $this->security->xss_clean(trim($this->inputs->get("p")));

        if (empty($tx_ref) or empty($project))
            return false;

        if (! $this->model->Projects_model->_is_project_belong_to_user($project, $username))
            if (!$this->model->Projects_model->_is_project_collaborator($project, $username))
                return false;

        $projects  = $this->model->Projects_model->get_user_projects($username, $project);

        if (empty($projects))
            return false;
        /*
         * Confirm if the transaction belongs to user
         */

        $response = $this->gdb_redis->zRangeByLex(self::PROJECT_SMS_TX_ZSET . $project, "[" . $tx_ref, "[" . $tx_ref);
        if (! $response)
            return [];
        $data = json_decode($this->gdb_redis->hGet(self::SMS_TX_SUCCESS_DETAILS, $tx_ref));
        $projects['sms'] = $data;
        return $projects;
    }

    /**
     * @throws Exception
     */
    function add_sms_tx_rate($user) {
        /*
         * These are the prices we buy and sell sms rates
         */
        $currency = $this->security->xss_clean(trim($this->inputs->post("currency")));
        $bp = $this->security->xss_clean(trim($this->inputs->post("bp")));
        $sp = $this->security->xss_clean(trim($this->inputs->post("sp")));
        if (empty($currency) or empty($bp) or empty($sp))
            return array("code" => 403,  "status" => "error", "title" => "Error", "message" => "Could not perform action");
        /*
         * Lets now get the country code from currency provided
         */
        $code = array_search($currency, $this->gdb_redis->hGetAll(self::COUNTRY_CURRENCY));
        if (empty($code))
            return array("code" => 403,  "status" => "error", "title" => "Error", "message" => "Could not get country code");

        $rate = $this->gdb_redis->hGet(self::PROJECT_SMS_RATES, $code);
        $data = [
            "buying_price" => $bp,
            "selling_price" => $sp,
            "user" => $user,
            "date_added" => date("Y-m-d"),
            "country_code" => $code
        ];
        $id = $this->gdb->insert("sms_rates", $data);
        if (empty($id))
            return array("code" => 403,  "status" => "error", "title" => "Error", "message" => "Could write to Database");

        $data['id'] = $id;
        $this->gdb_redis->hSet(self::PROJECT_SMS_RATES, $code, json_encode($data));
        return array("code" => 202,  "status" => "success", "title" => "Success", "message" => "Successfully executed.");
    }
}