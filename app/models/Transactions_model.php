<?php

use JetBrains\PhpStorm\ArrayShape;

class Transactions_model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->model("Projects_model");
        $this->model("Boosted_auth");
        $this->model("Organizations_model");
    }

    function _get_all_transactions($user) {

    }

    function _get_collections($user): array
    {
        $projects = $this->model->Projects_model->get_user_projects($user->username);
        $coll_transactions = [];
        foreach ($projects as $project) {
            $transactions = $this->_get_project_transactions($project->url);
            $i = 0;
            foreach ($transactions as $key => $transaction) {
                $transaction_body = json_decode($this->gdb_redis->hGet(COLLECTIONS_TX, $transaction));
                if (! empty($transaction_body)) {
                    $transaction_body->ref = explode("_", $transaction_body->tx_ref)[1];
                    $transaction_body->_request = $transaction_body->_request == 1 ? "MOBILE MONEY" : "CARD COLLECTION";
                    $transaction_body->status = $transaction_body->status ?? 2;
                    $transaction_body->project = $project->project;
                    $transaction_body->available_amount = isset($transaction_body->available_amount) ? number_format($transaction_body->available_amount, 2) : 0.00;
                    $transaction_body->url = $project->url;
                    $transaction_body->organization = $project->_namespace;
                    $transaction_body->amount = number_format($transaction_body->amount, 3);
                    $transaction_body->organization_url = $project->_namespace_url;
                    $transaction_body->names = isset($transaction_body->first_name) ? $transaction_body->first_name . " " . $transaction_body->last_name : 'Anonymous';
                }
                $coll_transactions[] = $transaction_body;
            }
        }
        return $coll_transactions;
    }

    function _get_project_transactions($project): bool | array
    {
        /*
         * Tx => transactions
         */
        return $this->gdb_redis->zRevRange(PROJECT_COLLECTIONS_TX . $project, 0, -1);
    }

    #[ArrayShape(["code" => "int", "status" => "string", "message" => "string"])] function get_tx_status($tx, $user): array
    {
        $project = trim($this->inputs->get("project"));
        if (empty($project))
            return array("code" => 500, "status" => "error", "message" => "An error occurred");

        if (! $this->model->Projects_model->_is_project_belong_to_user($project, $user->username))
            return array("code" => 503, "status" => "error", "message" => "Access Forbidden");

        /*
         * Let's use score to check if transaction exists for the project provided.
         */
        $_is_tx_for_project = $this->gdb_redis->zRank(PROJECT_COLLECTIONS_TX . $project, $tx);

        if (empty($_is_tx_for_project))
            return array("code" => 503, "status" => "error", "message" => "Transaction does not belong to Project");

        $project_data = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $project));

        if (empty($project_data) or empty($project_data->sid))
            return array("code" => 503, "status" => "error", "message" => "Access Forbidden");
        $headers  = [
            'Content-Type: application/json',
            'Accept-Charset: utf-8',
            'User-Access-Key: ' . $user->access_key,
            'Project-Sid: ' . $project_data->sid
        ];

        $data = [
            "tx" => $tx,
        ];

        $response = $this->model->Boosted_auth->make_Request("https://boosteds.xyz/tx/get_transaction", post_data : $data, headers : $headers);
        $response = json_decode($response);
        if ($response->code == -1)
            return ["status" => "error", "message" => $response->message];
        //print_r($response);
        $msg = $response->message;
        if ($msg->code != 200)
            return ["status" => "error", "message" => $msg->message];
        $msg->txRef = $tx;
        self::update_collection_tx($msg);
        return ["status" => $msg->status == "SUCCESSFUL" ? "success" : "error", "message" => $msg->status == "SUCCESSFUL" ? "Transaction Completed" : "Transaction Failed"];
    }

    function get_all_tx(): array
    {
        $mm_tx = $this->gdb_redis->zRevRange(isset($_GET['t']) && $_GET['t'] === "card" ? CARD_COLLECTIONS_TX : MM_COLLECTIONS_TX, 0, -1, "REV");
        $i = 0;
        $data = [];
        foreach ($mm_tx as $tx) {
            $r = json_decode($this->gdb_redis->hGet(COLLECTIONS_TX, $tx));
            $project = 0;
            //$this->gdb_redis->zAdd(isset($_GET['t']) && $_GET['t'] === "card" ? CARD_COLLECTIONS_TX : MM_COLLECTIONS_TX, $i++, $tx);
            //$this->gdb_redis->zIncrBy(isset($_GET['t']) && $_GET['t'] === "card" ? CARD_COLLECTIONS_TX : MM_COLLECTIONS_TX, 1, $tx);

            if (isset($r->project_url)) {
                $project = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $r->project_url));
                $project->owner = json_decode($this->redis->hGet(self::REDIS_USER_PROFILE, $project->username));
                $project->organization = $this->model->Organizations_model->get_organization_by_url(
                    $this->redis->hGet(self::REDIS_PROJECT_NAMESPACE, $r->project_url), $project->username, true);
                //print_r($project);
            }
            //print_r($project);
            $r->project_url = $project->project_url ?? null;
            $r->project_name = $project->project ?? null;
            $r->amount = number_format($r->amount, 2);
            $r->available_amount = isset($r->available_amount) ? number_format($r->available_amount, 2) : 0.00;

            $r->_request = $r->_request == 1 ? "MOBILE MONEY" : "CARD COLLECTION";
            $r->status = $r->status ?? 2;
            $r->user_image = $project->owner->image ?? null;
            $r->username = $project->username ?? null;
            $r->user_names = $project->owner->names ?? null;
            $r->namespace = $project->organization->name ?? null;
            $r->namespace_url = $project->organization->url ?? null;
            $r->namespace_image = $project->organization->logo ?? null;
            $data[] = (array)$r;
            //print_r($r);
        }
        return $data;
    }

    function pay_slip(): array
    {
        $names = trim($this->security->xss_clean($this->inputs->post("names")));
        $email = trim($this->security->xss_clean($this->inputs->post("email")));
        $phone_number = (int)trim(str_replace(" ", "", $this->security->xss_clean($this->inputs->post("phone_number"))));
        $comment = trim($this->security->xss_clean($this->inputs->post("comment")));
        $amount = (int)trim($this->security->xss_clean($this->inputs->post("amount")));
        $project = trim($this->security->xss_clean($this->inputs->post("project")));
        $country_code = (int)trim($this->security->xss_clean($this->inputs->post("code")));
        $names = empty($names) ? "Anonymous" : $names;
        $email = empty($email) ? "boosted_api@boostedtechs.com" : $email;
        $comment = empty($comment) ? "No comment" : $comment;

        if (strlen($phone_number) < 10)
            $phone_number = $country_code . $phone_number;

        if (empty($names) or empty($phone_number) or empty($project) or empty($amount))
            return ["status" => "error", "message" => "Names, amount and phone number shouldn't be left empty. Double check and try again when all is well."];

        if (self::is_valid_telephone_number($phone_number))
            $phone_number = self::normalise_phone_number($phone_number);
        else
            return ["status" => "error", "message" => "Phone number " . $phone_number . " is invalid"];

        if ($amount < 500)
            return ["status" => "error", "message" => "Amount should be above UGX 500"];

        $data = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $project));
        if (empty($data))
            return ["status" => "error", "message" => "Oooops, we got unlucky today"];
        $user = json_decode($this->redis->hGet(self::REDIS_USER_PROFILE, $data->username));
        if(empty($user))
            return ["status" => "error", "message" => "Oooops, we got unlucky today"];
        $headers  = [
            'Content-Type: application/json',
            'Accept-Charset: utf-8',
            'User-Access-Key: ' . $user->access_key,
            'Project-Sid: ' . $data->sid,
            'By_Pass_Sms:' . md5(time())
        ];
        $_names = explode(" ", $names);
        $data = [
            "first_name" => $_names[0],
            "last_name" => $_names[1] ?? '',
            "email_address" => $email,
            "phone_number" => $phone_number,
            "amount" => $amount,
            "description" => $comment . " ------ FROM PAYMENT COLLECTIONS SLIP",
            "currency" => "UGX",
            "request" => "mobile_money",
            "call_back_url" => (getenv('HTTPS') ? 'https://' : 'http://') . $this->server->server_name . "/webhook/in-app-payments/call-back?t=mm",
            "tx_ref" =>
                md5(str_replace(" ", "", $names) . str_replace(" ", "", $phone_number) . $email . $data->sid . $user->access_key . $amount . time())
        ];

        $response = $this->model->Boosted_auth->make_Request("https://boosteds.xyz/mm/collections", post_data : $data, headers : $headers);
        $response = json_decode($response);
        return $response->code == 200 ? ["code" => 200, 'status' => "success", "message" => "A push notification has been sent to <b class='text-info'>" . $phone_number . "</b>. Put your Mobile Money pin to complete transaction <b class='text-danger'>" . $response->tx_ref . "</b>."]
            :
            ["code" => 201, 'status' => "error", "message" => $response->message];
    }

    /**
     * @throws Exception
     */
    function update_collection_tx($response) {
        $status = $response->status == "SUCCESSFUL" ? 1 : 0;
        $tx_ref = $response->txRef;
        //$network_ref = $response->nework_ref ?? null;
        //$msisdn = $response->msisdn;
        $tx = self::get_coll_transaction($tx_ref);
        if ($tx->status != 2)
            return $tx;
        $update_data = [
            "actual_amount" => $status == 1 ? $response->amount : 0,
            "available_amount" => $status == 1 ? $response->amount * ((100 - 3.5) * 100) : 0,
            "status" => $status,
            //"network_ref" => $network_ref
        ];

        $this->gdb->where("id", $tx->id);
        $this->gdb->update("payment_collections", $update_data);

        $tx->status  = $status;
        //$tx->network_ref = $network_ref;
        $tx->actual_amount = $update_data['actual_amount'];
        $tx->available_amount = $update_data['available_amount'];
        if ($status == 1) {
            $tx->actual_amount = $response->amount;
            $deposit_charge = json_decode($this->gdb_redis->get(DEPOSIT_CHARGES));
            $deposit_charge = $deposit_charge->deposit_charge ?? 3.5;
            $charge  = ((100 - $deposit_charge) / 100);
            $tx->available_amount = $response->amount * $charge;
        }
        $transaction_status =  $status ? PASSED_COLLECTIONS_TX : FAILED_COLLECTIONS_TX;
        /*
         * Lets save failed and succeeded transactions
         */
        $set = $this->gdb_redis->zRange($transaction_status, 0 , -1);
        $i = 0;
        foreach ($set as $s)
            $this->gdb_redis->zAdd($transaction_status, $i++, $s);
        $score = $this->gdb_redis->zScore($transaction_status , $this->gdb_redis->zRevRange($transaction_status , 0, 0, "WITHSCORES")[0]) + 1;
        $this->gdb_redis->zAdd($transaction_status, $score, $tx_ref);
        self::update_coll_transaction($tx_ref, $tx);

        return $tx;
    }
    function update_coll_transaction($tx_ref, $tx) {
        $this->gdb_redis->hSet(COLLECTIONS_TX, $tx_ref, json_encode($tx));
    }
    function get_coll_transaction($tx) {
        return json_decode($this->gdb_redis->hGet(COLLECTIONS_TX, $tx));
    }

}