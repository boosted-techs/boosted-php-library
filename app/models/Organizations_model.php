<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 12/28/21
 * Time: 12:52 PM
 */

use JetBrains\PhpStorm\ArrayShape;

if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
class Organizations_model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->model("Accounts_model");
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(["status" => "string", "code" => "int", "message" => "string"])] function create_organization($user, $username): array
    {
        //print_r($this->inputs->post());
        $company = $this->strings->remove_special_chars($this->security->xss_clean(trim($this->inputs->post("company"))));
        $email = str_replace("-", " ", $this->security->xss_clean(trim($this->inputs->post("email"))));
        $website = str_replace("-", " ", $this->security->xss_clean(trim($this->inputs->post("website"))));
        $phone = str_replace("-", " ", $this->strings->remove_special_chars($this->security->xss_clean(trim($this->inputs->post("phone")))));
        $regNo = str_replace("-", " ", $this->strings->remove_special_chars($this->security->xss_clean(trim($this->inputs->post("regNo")))));
        $address = str_replace("-", " ", $this->strings->remove_special_chars($this->security->xss_clean(trim($this->inputs->post("address")))));
        $orgType = str_replace("-", " ", $this->strings->remove_special_chars($this->security->xss_clean(trim($this->inputs->post("orgType")))));

        if (! empty($email))
            if( ! $this->security->validate_email($email))
                return array("status" => "Error", "code" => -1, "message" => "Invalid email address");

        if (! empty($website))
            if (! $this->security->validate_url($website))
                return array("status" => "Error", "code" => -1, "message" => "Invalid Web address. The url should have a protocal eg http:// or https://");
        if (empty($company))
            return array("status" => "Error", "code" => -1, "message" => "Company name cannot be left blank");

        if (empty($orgType))
            return array("status" => "Error", "code" => -1, "message" => "An error with data processing occurred");

        /*
 * Lets check for duplicates of ORGS on the same user's account
 */
        if (self::is_org_for_user_exists($username, $company))
            return array("status" => "Record present", "code" => -1, "message" => "Duplicate record on your account for " . $company . " found.");

        /*
         * A user is only limited to at most 5 records or Organizations. Lets limit that here
         */
        if ($this->redis->lLen(self::REDIS_USER_ORGANIZATIONS . $username) >= 5)
            return array("status" => "Maximum Limit of 5 Hit!", "code" => -1, "message" => "Well, your account has reached the Maximum number of Organizations.");

        /*
         * Lets create unique URI slags for the organizations
         */
        $company_url = $this->model->Accounts_model->check_url_for_duplicates($company, self::REDIS_ORGANIZATIONS_LIST);
        $company_data = array(
            "user" => $user,
            "name" => str_replace("-", " ", $company),
            "website" => $website,
            "contacts" => $phone,
            "address" => $address,
            "reg_number" => $regNo,
            "logo" => "blank.png",
            "date_added" => date("Y-m-d"),
            "status" => 1,
            "deleted" => 0,
            "business_type" => $orgType,
            "sid" => self::password_hash($company_url . $user . date("Y-m-d")),
            "email" => $email,
            "url" => $company_url,
            "verified" => 0
        );
        $id = $this->db->insert("organizations", $company_data);
        /*
         * Make sure the insertion is successfull
         */
        if (! $id)
            return array("status" => "Error", "code" => -1, "message" => "Could not save record");

        $company_data['id'] = $id;
        /*
         * Add username to organization data set
         */
        $company_data['username'] = $username;
        /*
         * Lets store company data in a hash set
         */
        $this->redis->hSet(self::REDIS_ORGANIZATIONS_LIST, $company_url, json_encode($company_data));
        /*
         * Lets store all organizations urls in a list
         */
        $this->redis->lPush(self::REDIS_ORGANIZATIONS, $company_url);
        /*
         * Lets store all user companies in a list
         */
        $this->redis->lPush(self::REDIS_USER_ORGANIZATIONS.$username, $company_url);
        return array("status" => "Success", "code" => 1, "message" => "Record successfully added.");
    }

    function get_organizations_by_user($user): array
    {
        $user_organizations = $this->redis->lRange(
            self::REDIS_USER_ORGANIZATIONS . $user,
            0,
            ($this->redis->lLen(self::REDIS_USER_ORGANIZATIONS . $user) - 1)
        );
        $organizations_list = [];

        foreach ($user_organizations as $organization_url)
            $organizations_list[] = json_decode($this->redis->hGet(self::REDIS_ORGANIZATIONS_LIST, $organization_url));

        return $organizations_list;
    }

    function is_org_for_user_exists($username, $url): bool
    {
        $url = strtolower($url);
        return !(!in_array($url, $this->redis->lRange(
            self::REDIS_USER_ORGANIZATIONS . $username,
            0,
            ($this->redis->lLen(self::REDIS_USER_ORGANIZATIONS . $username)) - 1)));
    }

    function get_organization_by_url($url, $username, $security_check = true) {
        if ($security_check) /*  Lets ignore the check for ownership incase the user is just a collaborator*/
            if(! self::is_org_for_user_exists($username, $url))
                return false;
        return json_decode($this->redis->hGet(self::REDIS_ORGANIZATIONS_LIST, $url));
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(["status" => "string", "code" => "int", "message" => "string"])] function update_organization($username): array
    {
        $url = $this->inputs->post("url");
        if(! self::is_org_for_user_exists($username, $url))
            return array("status" => "Forbidden", "code" => -1, "message" => "Forbidden Action");

        $company = $this->security->xss_clean(trim($this->inputs->post("company")));
        $email = str_replace("-", " ", $this->security->xss_clean(trim($this->inputs->post("email"))));
        $website = str_replace("-", " ", $this->security->xss_clean(trim($this->inputs->post("website"))));
        $phone = str_replace("-", " ", $this->strings->remove_special_chars($this->security->xss_clean(trim($this->inputs->post("phone")))));
        $regNo = str_replace("-", " ", $this->strings->remove_special_chars($this->security->xss_clean(trim($this->inputs->post("regNo")))));
        $address = str_replace("-", " ", $this->strings->remove_special_chars($this->security->xss_clean(trim($this->inputs->post("address")))));
        $orgType = str_replace("-", " ", $this->strings->remove_special_chars($this->security->xss_clean(trim($this->inputs->post("orgType")))));
        $status = $this->inputs->post("status");
        if (! empty($email))
            if( ! $this->security->validate_email($email))
                return array("status" => "Error", "code" => -1, "message" => "Invalid email address");

        if (! empty($website))
            if (! $this->security->validate_url($website))
                return array("status" => "Error", "code" => -1, "message" => "Invalid Web address. The url should have a protocal eg http:// or https://");
        if (empty($company))
            return array("status" => "Error", "code" => -1, "message" => "Company name cannot be left blank");

        $logo = self::upload_profile_pic($url);
        $organization = self::get_organization_by_url($url, $username);

        /*
         * Lets update the organization profile object information
         */
        $organization->name = $company;
        $organization->email = $email;
        $organization->website = $website;
        $organization->contacts = $phone;
        $organization->address = $address;
        $organization->reg_number = $regNo;
        $organization->logo = $logo == false  ? $organization->logo : $logo;
        $organization->status = $status == 1 ? 1 : 0;
        $organization->business_type = $orgType;
        $username = $organization->username;
        unset($organization->username);
        $this->db->where("id", $organization->id);
        $query = $this->db->update("organizations", (array)$organization);
        if ($query) {
            /*
         * Lets store company data in a hash set
         */
            $organization->username = $username;
            $this->redis->hSet(self::REDIS_ORGANIZATIONS_LIST, $url, json_encode($organization));
            return array("status" => "Update successful", "code" => 1, "message" => "Successfully updated namespace " . $company);
        }
        return array("status" => "Error", "code" => -1, "message" => "Could not update record.");
    }

    function upload_profile_pic($url): bool|string
    {
        if (! isset($_FILES['file']['name']))
            return false;
        $file_name = $_FILES['file']['name'];
        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = self::password_hash($url) . "." . $extension;
        $tmp_file = $_FILES['file']['tmp_name'];
        $size = filesize($tmp_file);

        if ($size > pow(1024, 2))
            return false;
        $accepted_files = array("jpg", "jpeg", "png", "gif");
        if (in_array($extension, $accepted_files)) {
            move_uploaded_file($tmp_file, "profile_pics/" . $new_file_name);
            return $new_file_name . "?i=" . random_int(400, 4000);
        }
        return false;
    }

}