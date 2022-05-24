<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 1/4/22
 * Time: 6:55 PM
 */

use JetBrains\PhpStorm\ArrayShape;

if ( !defined('APPLICATION_LOADED') || !APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
class Projects_model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->model("Accounts_model");
        $this->model("Organizations_model");
        $this->model("Mail_model");
    }

    #[ArrayShape(["status" => "string", "code" => "int", "message" => "string"])] function create_new_project($username, $user): array
    {
        $namespace = $this->security->xss_clean(trim($this->inputs->post("namespace")));
        $project = $this->security->xss_clean(trim($this->inputs->post("project_name")));
        $project_type = $this->security->xss_clean(trim($this->inputs->post("project")))  == 1 ? 1 : 2;
        $description  = $this->security->xss_clean(trim($this->inputs->post("description")));
        $collections  = $this->inputs->post("collections");
        $utilities = $this->inputs->post("utilities");
        //print_r($utilities); die();

        $namespace_id = $this->model->Organizations_model->get_organization_by_url($namespace, $username);
        if (empty($project) or ! in_array($project_type, [1, 2]))
            return array("status" => "Data error", "code" => -1, "message" => "You must provide the Project name, namespace and project type. ie SMS or Payments");

        if (empty($namespace))
            return array("status" => "Missing Namespace", "code" => -1, "message" => "Namespace / organization is left empty. Create one before you can proceed. <br/> <a href='/p/namespace/organizations.boosted'><button class='btn btn-outline-success'>Create Namespace</button></a>");


        if ($this->is_project_exists($namespace, $project))
            return array("status" => "Forbidden", "code" => -1, "message" => "Project exists for that namespace " . $namespace_id->name);

        /*
         * Each org / namespace must have only 5 projects
         */
        if ($this->redis->lLen(self::REDIS_ORG_PROJECTS_LIST . $namespace) >= 5)
            return array("status" => "Maximum Limit", "code" => -1, "message" => "You have hit the maximum number of projects for Namespace " . $namespace_id->name);

        /*
         * Lets convert the utilities and collections array into a string
         */
        if (! empty($collections))
            $collections = implode(",", $collections);
        /*
         * Implode functions does the magic
         */
        if (! empty($utilities))
            $utilities = implode(",", $utilities);

        $project_url = $this->model->Accounts_model->check_url_for_duplicates(
            $this->strings->remove_special_chars($project), self::REDIS_PROJECTS);

        $data_array = array(
            "project" => $project,
            "sid" => self::password_hash($project_url . $username . $namespace . random_int(300, 1000)),
            "description" => $description,
            "utilities" => $utilities,
            "collection" => $collections,
            "date_added" => date("Y-m-d"),
            "user" => $user,
            "namespace" => $namespace_id->id,
            "project_type" => $project_type,
            "domains" => '',
            "url" => $project_url,
            "live" => 0,
            "status" => 1,
            "deleted" => 0
        );
        $project_id = $this->db->insert("projects", $data_array);
        if (! $project_id)
            return array("status" => "Forbidden", "code" => -1, "message" => "Could not create project");
        $data_array['id'] = $project_id;
        /*
         * Lets add Username to be able to get owner of the project with a single redis query
         */
        $data_array['username'] = $username;
        /*
         * PUSH PROJECT TO LIST
         */
        $this->redis->lPush(self::REDIS_PROJECTS_LIST, $project_url);
        /*
         * Saving the project to user instance
         */
        $this->redis->lPush(self::REDIS_USER_PROJECTS_LIST . $username, $project_url);
        /*
         * Saving project to organizations list
         */
        $this->redis->lpush(self::REDIS_ORG_PROJECTS_LIST . $namespace, $project_url);
        /*
         * Lets now save the project to a HASHED SET
         *
         */
        $this->redis->hSet(Self::REDIS_PROJECTS, $project_url, json_encode($data_array));
        /*
         * Lets save the SID in a hash for easy API CALLS
         */
        $this->redis->hSet(self::REDIS_PROJECT_SIDS, $data_array['sid'], $project_url);
        /*
         * Save the namespace with the project
         */
        $this->redis->hSet(self::REDIS_PROJECT_NAMESPACE, $project_url, $namespace);
        /*
         * Return success
         */
        return array("status" => "Success", "code" => 1, "message" => "Project " . $project ." for namespace " . $namespace_id->name . " has been successfully created.");

    }

    function is_project_exists($organization, $project_name): bool
    {
        $project_name = strtolower($this->strings->remove_special_chars($project_name));
        return !(!in_array($project_name, $this->redis->lRange(
            self::REDIS_ORG_PROJECTS_LIST . $organization,
            0,
            ($this->redis->lLen(self::REDIS_ORG_PROJECTS_LIST . $organization)))));

    }

    function _is_project_belong_to_user($project, $username): bool
    {
        return ! (!in_array($project, $this->redis->lRange(
            self::REDIS_USER_PROJECTS_LIST . $username,
            0,
            ($this->redis->lLen(self::REDIS_USER_PROJECTS_LIST . $username)))));

    }

    function _is_project_collaborator($project, $username): bool
    {
        return in_array($project, (array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $username)));
    }

    function get_user_projects($username, $project_url = false): bool|array
    {
        $project_url = $this->security->xss_clean($project_url);
        if (! $project_url) {
            $projects = $this->redis->lRange(self::REDIS_USER_PROJECTS_LIST . $username,
                0, ($this->redis->lLen(self::REDIS_USER_PROJECTS_LIST . $username)));
            /*
             * All get the projects the User collaborates on
             */
            $d = json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $username));
            if (! empty($d))
                foreach ($d as $item => $value)
                    $projects[] = $value;
        } else {
            /*
             * Lets check if the project belongs to user or user has access
             */
            $projects = [$project_url];
        }
        $projects_data = [];
        foreach ($projects as $item => $value) :
            if (! $this->_is_project_belong_to_user($value, $username))
                if (! self::_is_project_collaborator($value, $username))
                   continue;

            $project = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $value));
            /*
             * Lets get the organization onto which this project belongs
             */
            $organization = $this->model->Organizations_model->get_organization_by_url(
                $this->redis->hGet(self::REDIS_PROJECT_NAMESPACE, $value), $username, false);

            //print_r($organization);

            $project->_namespace = $organization->name ?? "NULL";
            $project->_namespace_url = $organization->url ?? "NULL";
            $project->_namespace_logo = $organization->logo ?? "NUll";
            $project->_namespace_sid = $organization->sid ?? "NULL";

            $projects_data[] = $project;
            //echo $value;
        endforeach;
        return $projects_data ?:  false;
    }

    #[ArrayShape(["status" => "string", "code" => "int", "message" => "string"])] function update_project($username, $project_url): array
    {
        $project_rights = $this->_is_project_belong_to_user($project_url, $username);
        if (! $project_rights)
            if (! self::_is_project_collaborator($project_url, $username))
            return array("status" => "Error 503", "code" => -1, "message" => "Action not Permitted");

        $description  = $this->security->xss_clean(trim($this->inputs->post("description")));

        $project_object = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $project_url));
        //$status = $this->inputs->post("")

        if (empty($project_object))
            return array("status" => "Error 503", "code" => -1, "message" => "Action not Permitted");

        $project = $this->security->xss_clean(trim($this->inputs->post("project_name")));

        if (empty($project))
            return array("status" => "Data error", "code" => -1, "message" => "You must provide the Project name, namespace and project type. ie SMS or Payments");

        $project_object->description = $description;
        $project_object->project = $project;
        $project_object->status = $this->inputs->post("status") == 1 ? 1 : 0;
        $project_object->live = $this->inputs->post("live") == 1 ? 1 : 0;
        $this->db->where("id", $project_object->id);
        $id = $this->db->update("projects",
            array("status" => $project_object->status,
                "live" => $project_object->live,
                "project" => $project_object->project,
                "description" => $project_object->description));
        if (! $id)
            return array("status" => "Data error", "code" => -1, "message" => "Project " . $project_object->project . " update has failed.");

        $this->redis->hSet(self::REDIS_PROJECTS, $project_object->url, json_encode($project_object));
        return array("status" => "Success", "code" => 1, "message" => "Project " . $project_object->project . " has successfully been updated.");
    }

    #[ArrayShape(["status" => "string", "code" => "int", "message" => "string"])] function update_project_domains($username, $project_url): array
    {
        $url = $this->security->xss_clean(trim($this->inputs->post("url")));
        $url1 = $this->security->xss_clean(trim($this->inputs->post("url1")));
        $url2 = $this->security->xss_clean(trim($this->inputs->post("url2")));
        $url3 = $this->security->xss_clean(trim($this->inputs->post("url3")));
        $url4 = $this->security->xss_clean(trim($this->inputs->post("url4")));

        $urls[] = $url;
        $urls[] = $url1;
        $urls[] =  $url2;
        $urls[] =   $url3;
        $urls[] =  $url4;

        $project_rights = $this->_is_project_belong_to_user($project_url, $username);
        if (! $project_rights)
            if (! self::_is_project_collaborator($project_url, $username))
                return array("status" => "Error 503", "code" => -1, "message" => "Action not Permitted");

        $project_object = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $project_url));
        //$status = $this->inputs->post("")

        if (empty($project_object))
            return array("status" => "Error 503", "code" => -1, "message" => "Action not Permitted");

        $this->redis->del($project_url . self::REDIS_PROJECT_DOMAINS);
        $this->redis->lPush($project_url . self::REDIS_PROJECT_DOMAINS, "0", '', '', '', '');
        $domains = [];
        $error = 0;
        foreach ($urls as $key => $value) {
            if ($value == "null")
                continue;

            if (!empty($value)) {
                $new_url = parse_url($value);
                if (!isset($new_url['scheme'])) :
                    $error = 1;
                    continue;
                endif;
                if (! in_array($new_url['scheme'], ['https', 'http'])) :
                    //Lets only accept connections from http
                    $error = 1;
                    continue;
                endif;
                if ($new_url['scheme'] != "https") :
                    //Only accept connections from secure connection
                    $error = 1;
                    //continue;
                endif;
                if (!isset($new_url['path'])) :
                    $error = 1;
                    continue;
                endif;
                $domains[] = $value;
                $this->redis->lSet($project_url . self::REDIS_PROJECT_DOMAINS, $key, $value);
            }
        }

        //print_r($this->redis->lRange($project_url . self::REDIS_PROJECT_DOMAINS, 0, 5));

        /*
         * Lets save the string Here
         */
        if (! empty($domains)) :
        $domains = implode(",", $domains);
        $this->db->where("id", $project_object->id);
        $this->db->update("projects", array("domains" => $domains));

        /*
         * Lets update the Redis object
         */
        $project_object->domains = $domains;
        $this->redis->hSet(self::REDIS_PROJECTS, $project_url, json_encode($project_object));
            return array("status" => "Success", "code" => 1, "message" => "Domains successfully updated for project " . $project_object->project);
        else :
            return array("status" => "Error 503", "code" => -1, "message" => "Could not update domains for project " . $project_object->project);

        endif;
    }

    #[ArrayShape(["status" => "string", "code" => "int", "message" => "string"])] function add_collaborator($username, $user, $names): array
    {
        $collaborator = $this->security->xss_clean(trim($this->inputs->post("username")));
        $project = $this->security->xss_clean(trim($this->inputs->post('project')));
        if (empty($collaborator) || empty($project) || strcmp($username, $collaborator) == 0)
            return array("status" => "Error 503", "code" => -1, "message" => "We could not work on this at this time");

        if (! $this->_is_project_belong_to_user($project, $username))
            return array("status" => "Error 503", "code" => -1, "message" => "Forbidden Access.");

        $collaborator_object = $this->model->Accounts_model->search_user($username, $collaborator);
        $project_object = $this->get_user_projects($username, $project)[0];

        /*
         * We check if collaboration exists. If yes, we stop return and exit from collaborating
         */
        $project_collaborations_request_list = $this->redis->hGet(self::REDIS_PC_REQUESTS, $project);
        $project_collaborations_list = $this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $project);

        $has_collaboration_requests = (array)json_decode($project_collaborations_request_list);

        if (! empty($has_collaboration_requests)) {

            if (in_array($collaborator, $has_collaboration_requests)) {
                $message = "Hello <b>" . $collaborator_object->names . "</b> you have been invited by <b>" . $names . "</b> to collaborate on project <b>" . $project_object->project . "</b>. <br/> click on link to go to dashboard <a href='//" . $this->server->server_name . "/p/namespace/collaborations.boosted'>Collaborations</a>";
                //$this->model->Mail_model->send_mail($collaborator_object->email, $message, "Project Invitation");
                return array("status" => "Request Exists", "code" => -1, "message" => "A request already exists. However, a new invitation mail has been sent to the " . $collaborator_object->names . " as a reminder.");
            }
        }


        $collaboration_data_array = (array)json_decode($project_collaborations_list);
        if (! empty($collaboration_data_array))
            if (in_array($collaborator, $collaboration_data_array))
                return array("status" => "Collaboration Exists", "code" => -1, "message" => "User collaboration exists for project" . $project_object->project);


        $this->db->insert("collaboration_requests",
            array("project" => $project_object->id,
                "date_added" => date("Y-m-d"),
                "owner" => $user,
                "collaborator" => $collaborator_object->user));

        $user_project_requests_list = (array)json_decode($this->redis->hGet(self::REDIS_PC_REQUESTS, $collaborator));


        /*
         * Has collaborations for project hash
         */
        $has_collaboration_requests[] = $collaborator;
        /*
         * Has projects for collaboration hash
         */
        $user_project_requests_list[] = $project;


        $this->redis->hSet(self::REDIS_PC_REQUESTS, $collaborator,  json_encode($user_project_requests_list));
        $this->redis->hSet(self::REDIS_PC_REQUESTS, $project,  json_encode($has_collaboration_requests));

        $message = "Hello <b>" . $collaborator_object->names . "</b> you have been invited by <b>" . $names . "</b> to collaborate on project <b>" . $project_object->project . "</b>. <br/> click on link to go to dashboard <a href='//" . $this->server->server_name . "/p/namespace/collaborations.boosted'>Collaborations</a>";
        //$this->model->Mail_model->send_mail($collaborator_object->email, $message, "Project Invitation");

        return array("status" => "Invitation successful", "code" => 1, "message" => "You have successfully invited " . $collaborator_object->names . " to collaborate with you on project " . $project_object->project);

    }

    function get_project_collaborations($project, $username): array
    {

        if (! $this->_is_project_belong_to_user($project, $username))
            return array("status" => "Error 503", "code" => -1, "message" => "Forbidden Access.");

        $collaborators_request_list = json_decode($this->redis->hGet(self::REDIS_PC_REQUESTS, $project));
        $data['requests'] = [];
        $data['collaborations'] = [];

        /*
         * List of requests
         */

        foreach ($collaborators_request_list as $item)
            $data['requests'][] = json_decode($this->redis->hGet(self::REDIS_USER_PROFILE, $item));

        /*
         * List of collaborators
         */
        $collaborators_list = (array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $project));
        foreach ($collaborators_list as $item)
            $data['collaborations'][] = json_decode($this->redis->hGet(self::REDIS_USER_PROFILE, $item));


        return $data;

    }

    #[ArrayShape(["status" => "string", "code" => "int", "message" => "string"])] function remove_collaborator($username, $delete_all = true): array
    {
        $project = $this->security->xss_clean(trim($this->inputs->post("project")));
        $collaborator = $this->security->xss_clean(trim($this->inputs->post("collaborator")));

        if (empty($project) or empty($collaborator))
            return array("status" => "Error 503", "code" => -1, "message" => "Forbidden Access.");

        if (! $this->_is_project_belong_to_user($project, $username))
            return array("status" => "Error 504", "code" => -1, "message" => "Forbidden Access.");

        if (strcmp($username, $collaborator) === 0)
            return array("status" => "Error 504", "code" => -1, "message" => "You cannot be your own contributor to your project.");


        $project_collaborations_request_list = (array)json_decode($this->redis->hGet(self::REDIS_PC_REQUESTS, $project));
        $project_collaborations_list = (array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $project));

        $user_project_collaboration_list = (array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $collaborator));
        $user_project_requests_list = (array)json_decode($this->redis->hGet(self::REDIS_PC_REQUESTS, $collaborator));


        //print_r($user_project_requests_list);
        $collaborator_object = $this->model->Accounts_model->search_user($username, $collaborator);
        $project_object = $this->get_user_projects($username, $project)[0];
        //die();

        /*
         * Lets clean the redis .. we begin with the project hash on both request and collaborations
         */
        //Requests
        $this->update_project_collaborators_list($project_collaborations_request_list, $collaborator, $user_project_requests_list, $project, $project_collaborations_list, $user_project_collaboration_list);

        /*
         * Update collaborations request table
         */
        $this->db->where("project", $project_object->id);
        $this->db->where("collaborator", $collaborator_object->user);
        $this->db->update("collaboration_requests", array("deleted" => 1));

        /*
         * Update collaborations table
         */
        $this->db->where("project", $project_object->id);
        $this->db->where("collaborator", $collaborator_object->user);
        $this->db->update("collaboration_requests", array("deleted" => 1));
        return array("status" => "Success", "code" => 1, "message" => "Successfully modified record.");

    }

    function get_user_project_collaborations($username): array
    {

        $collaborators_request_list = json_decode($this->redis->hGet(self::REDIS_PC_REQUESTS, $username));
        $data['requests'] = [];
        $data['collaborations'] = [];

        /*
         * List of requests
         */

        foreach ($collaborators_request_list as $item)
            $data['requests'][] = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $item));

        /*
         * List of collaborators
         */
        $collaborators_list = (array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $username));
        foreach ($collaborators_list as $item)
            $data['collaborations'][] = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $item));


        return $data;
    }

    #[ArrayShape(["status" => "string", "code" => "int", "message" => "string"])] function accept_collaboration($username, $user, $url): array
    {

        $user_project_collaboration_list = (array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $username));
        $user_project_requests_list = (array)json_decode($this->redis->hGet(self::REDIS_PC_REQUESTS, $username));

        if (! in_array($url, $user_project_requests_list))
            return array("status" => "Error 504", "code" => -1, "message" => "Forbidden Access.");

        /*
         * Lets add the project to the projects url
         */
        $user_project_collaboration_list[] = $url;

        $project_object = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $url));

        //echo $project_object;
        //print_r($project_object);
        if (empty($project_object))
            return array("status" => "Error 504", "code" => -1, "message" => "Forbidden Access.");

        $id = $this->db->insert("project_collaborations",
            array("project" => $project_object->id, "owner" => $project_object->user,
                "collaborator" => $user, "date_added" => date("Y-m-d")));
        if ($id) {
            $this->redis->hSet(self::REDIS_PROJECT_COLLABORATION, $username, json_encode($user_project_collaboration_list));
            unset($user_project_requests_list[array_search($url, $user_project_requests_list)]);
            $this->redis->hSet(self::REDIS_PC_REQUESTS, $username, json_encode($user_project_requests_list));

            $project_collaborations_request_list = (array)json_decode($this->redis->hGet(self::REDIS_PC_REQUESTS, $url));
            unset($project_collaborations_request_list[array_search($username, $project_collaborations_request_list)]);
            $this->redis->hSet(self::REDIS_PC_REQUESTS, $url, json_encode($project_collaborations_request_list));

            $project_collaborations_list = (array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $url));
            $project_collaborations_list[] = $username;
            $this->redis->hSet(self::REDIS_PROJECT_COLLABORATION, $url, json_encode($project_collaborations_list));

        }
        return array("status" => "Success", "code" => 1, "message" => "Successfully accepted collaboration to project " . $project_object->project);
    }

    #[ArrayShape(["status" => "string", "code" => "int", "message" => "string"])] function revoke_user_collaboration($username, $user): array
    {
        $url = $this->security->xss_clean(trim($this->inputs->post("project")));
        $user_project_collaboration_list = (array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $username));
        $user_project_requests_list = (array)json_decode($this->redis->hGet(self::REDIS_PC_REQUESTS, $username));

        if (! in_array($url, $user_project_requests_list))
            if (! in_array($url, $user_project_collaboration_list))
                return array("status" => "Error 504", "code" => -1, "message" => "Forbidden Access.");

        $project_collaborations_request_list = (array)json_decode($this->redis->hGet(self::REDIS_PC_REQUESTS, $url));
        $project_collaborations_list = (array)json_decode($this->redis->hGet(self::REDIS_PROJECT_COLLABORATION, $url));

        $this->update_project_collaborators_list($project_collaborations_request_list, $username, $user_project_requests_list, $url, $project_collaborations_list, $user_project_collaboration_list);

        /*
         * Update collaborations request table
         */
        $project_object = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $url));

        $this->db->where("project", $project_object->id);
        $this->db->where("collaborator", $user);
        $this->db->update("collaboration_requests", array("deleted" => 1));

        /*
         * Update collaborations table
         */
        $this->db->where("project", $project_object->id);
        $this->db->where("collaborator", $user);
        $this->db->update("collaboration_requests", array("deleted" => 1));
        return array("status" => "Success", "code" => 1, "message" => "Successfully modified record.");

    }

    /**
     * @param array $project_collaborations_request_list
     * @param string $collaborator
     * @param array $user_project_requests_list
     * @param string $project
     * @param array $project_collaborations_list
     * @param array $user_project_collaboration_list
     * @return void
     */
    public function update_project_collaborators_list(array $project_collaborations_request_list, string $collaborator, array $user_project_requests_list, string $project, array $project_collaborations_list, array $user_project_collaboration_list): void
    {
        unset($project_collaborations_request_list[array_search($collaborator, $project_collaborations_request_list)]);
        unset($user_project_requests_list[array_search($project, $user_project_requests_list)]);
        //print_r($project_collaborations_request_list);
        //print_r($user_project_requests_list);

        //Collaborations
        unset($project_collaborations_list[array_search($collaborator, $project_collaborations_list)]);
        unset($user_project_collaboration_list[array_search($project, $user_project_collaboration_list)]);

        /*
         * Lets now update our lists
         */

        $this->redis->hSet(self::REDIS_PC_REQUESTS, $project, json_encode($project_collaborations_request_list));
        $this->redis->hSet(self::REDIS_PROJECT_COLLABORATION, $project, json_encode($project_collaborations_list));

        $this->redis->hSet(self::REDIS_PROJECT_COLLABORATION, $collaborator, json_encode($user_project_collaboration_list));
        $this->redis->hSet(self::REDIS_PC_REQUESTS, $collaborator, json_encode($user_project_requests_list));
    }

    function get_project($project) {
        $data = json_decode($this->redis->hGet(self::REDIS_PROJECTS, $project));
        //print_r($data);
        if (! empty($data)) {
            if ($data->status == 0)
                return [];

            $data->org = (array)$this->model->Organizations_model->get_organization_by_url(
                $this->redis->hGet(self::REDIS_PROJECT_NAMESPACE, $project), $data->username, true);

            if (empty($data->org) or $data->org['deleted'] == 1)
                return [];
        }
        return $data;
    }
}