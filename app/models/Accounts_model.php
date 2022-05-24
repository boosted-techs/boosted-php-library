<?php
if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}

class Accounts_model extends Model {
    function __construct() {
        parent::__construct();
    }

    function check_url_for_duplicates($hash_key, $key): string
    {
        /*
         * We make it purely redis for reading
         */

        /*
         * Lets check if has already exists in $hash_key hashset
         * if yes, then it means the username / url is taken up
         * so we try to create another one from the provided data
         *
         */
        $hash_key = strtolower($hash_key);
        if ($this->redis->hExists($key, $hash_key)) {
            $url_string = explode("-", $hash_key);
            $url_counter = end($url_string);
            if (is_numeric($url_counter))
                $url_counter++;
            else
                $url_counter = $url_counter."-1";
            array_pop($url_string);
            $url_string[] = $url_counter;
            $hash_key = implode("-", $url_string);
            $hash_key = $this->check_url_for_duplicates($hash_key, $key);;
        }
        return $hash_key;
    }

    /**
     * @throws Exception
     */
    function update_user_data($data, $token): bool
    {
        if (empty($data))
            return false;
        $username = $this->create_username($data->names);
        $this->db->where("user", $data->user);
        $value = $this->db->getOne("basic_info", "user, username, role, security_options, date_added");

        $user_info =  array("user" => $data->user,
            "names" => $data->names,
            "email" => $data->email,
            "image" => $data->image,
            "country" => $data->country,
            "dob" => $data->dob,
            "theme" => $data->theme,
            "gender" => $data->gender,
            "continent" => $data->continent,
            "city" => $data->city,
            "username" => $username,
            "date_added" => date("Y-m-d H:i:s"),
            "role" => 0,
            "security_options" => null);
        /*
         * Lets check if the user has a login in the system.
         * If not, we insert else we just update the existing data
         */

        if (empty($value)) {
            /*
             * New login
             */
            $this->db->insert(self::SQL_BASIC_INFO_TABLE, $user_info);
            $this->redis->zAdd(self::REDIS_ALL_USERS_LIST, $this->redis->zScore(self::REDIS_ALL_USERS_LIST, $this->redis->zRevRange(self::REDIS_ALL_USERS_LIST, 0, 0, "WITHSCORES")[0]) + 1, $user_info['username']);
        }
        else {
            /*
             * Lets not change the username that was assigned on the first time of login in the app
             */
            /*
             * Lets initiate the update
             */
            /*
             * Lets update the username from the one being updated by the username method
             */
            $user_info['username'] = $value['username'];
            $user_info['role']     = $value['role'];
            $user_info['security_options'] = $value['security_options'];
            unset($user_info['date_added']);
            $this->db->where("user", $data->user);
            $this->db->update(self::SQL_BASIC_INFO_TABLE, $user_info);
            $user_info['date_added'] = $value['date_added'];
        }

        /*
         *Insert the token and key
         */
        //$this->redis->flushDB();
        $this->db->insert("login_tokens", array("access_key" => $token, "user" => $data->user, "date_added" => date("Y-m-d")));
        /*
         * Add login token to the hset. Make it unique
         */
        $this->redis->hSetNx(self::REDIS_LOGIN_TOKENS, $token, $user_info['username']);
            /*
             * We save the usernames in a list so that for every login, we can get it stored uniquely so that at the end of it all, we know
             * who is logged in from redis
             */

        /*
         * Check if there exists an access key
         */
        $this->db->where("user", $data->user);
        $this->db->orderBy("id", "desc");
        $this->db->where("deleted", 0);
        $access_key = $this->db->getValue("access_keys", "access_key");
        if ($access_key)
            $user_info['access_key'] = $access_key;
        else {
            $new_access_key = $this->password_hash($user_info['username'] . date("Y-m-d h:i:s") . $data->user);
            $this->db->insert("access_keys",
                array("user" => $data->user,
                    "date_added" => date("Y-m-d"),
                    "access_key" => $new_access_key
                    )
            );
            $user_info['access_key'] = $new_access_key;
        }
        /* Lets check if access key key exists  is the user access list
        *
        */

        if (empty(self::is_key_for_user_exists($user_info['username'], $user_info['access_key'])))
            $this->redis->zAdd(self::USER_ACCESS_KEYS_list . $user_info['username'], "+inf", $user_info['access_key']);

       /*
        * Removing duplicate values for a specific username
        * Only one Record should be stored in HASH with a UAK
        */
        $this->remove_user_auk($user_info['username']);

        /*
         * Lets store the access key in an HASHED SET for easy API calls when the client request for services
         */
        $this->redis->hSet(self::ACCESS_KEYS, $user_info['access_key'], $user_info['username']);
        /*
         * Add user data to Hash table
         */
        $this->redis->hSet(self::REDIS_USER_PROFILE, $user_info['username'], json_encode($user_info));
        /*
         * Save users to the database.
         * This is aimed at doing all the reading from redis other than Mysql
         */
        return true;
    }

    function remove_user_auk($username) {
        /*
         * Lets clean the UAK list and make sure only one record exists for a user
         */
        $data = $this->redis->hGetAll(self::ACCESS_KEYS);
        $keys = array_keys($data, $username);

        foreach ($keys as $key)
                $this->redis->hDel(self::ACCESS_KEYS, $key);
    }

    function is_key_for_user_exists($username, $key) : array
    {
        /*
         * Access keys is what is being checked for here
         */
        $key = strtolower($key);
        return $this->redis->zRangeByLex(self::USER_ACCESS_KEYS_list . $username, "[" . $key, "[" . $key);
    }

    function create_username($names): string
    {
        /*
         * Creating new username for new login
         */

        /*
         * Check if username exists. If yes, create a new one and return it
         */
        return $this->check_url_for_duplicates(
            /*
             * Username which is the hash key in this case
             */
            strtolower(
                /*
                 * In the names, remove all special characters and then remove the white spaces
                 */
                $this->strings->remove_special_chars(
                    /*
                     * Lets get rid of non UTF characters
                     */
                    $this->strings->remove_none_utf_char($names)
                )
                /*
                 * Pass the key and hash key to check for username
                 */
            ), /* key for hash */ self::REDIS_USER_PROFILE
        );
    }

    function active_domain() {
        $this->model("Api_model");
        return $this->model->Api_model->get_active_domain();
    }


    function destroy_cookie() {
        if (empty($this->cookie->cookie->auth))
            return false;
        $this->redis->hDel(self::REDIS_LOGIN_TOKENS, $this->cookie->cookie->auth);
    }

    function get_user($username = false) {
        /*
         * Lets get the username from the login tokens
         * It should be noted that if the user logs out, the login token is deleted from the redis hash so an empty string is most likely to be sent as response
         */
        if (empty($username))
            $username = $this->redis->hGet(self::REDIS_LOGIN_TOKENS, $this->cookie->cookie->auth);

        if (empty($username))
            /*
             * If nothing is found, return false value
             */
            return false;
        /*
         * Lets go ahead and get the user data from the
         * A json response is provided on success
         */

        return json_decode($this->redis->hGet(self::REDIS_USER_PROFILE, $username));
    }

    function search_user($username, $username_2 = false) {
        $search =  trim($this->inputs->post("username"));
        $search = $username_2  == false ? $search : $username_2;

        if (strcmp($search, $username) == 0 or empty($search))
            return false;

        $search = $this->security->xss_clean($search);
        $result = $this->redis->hGet(self::REDIS_USER_PROFILE, $search);
        return $result? json_decode($result) : $result;
    }

}