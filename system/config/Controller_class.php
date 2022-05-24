<?php
/**
 * Created by PhpStorm.
 * User: Ashiraff Tumusiime
 * Company: Boosted Technologies LTD
 * Date: 7/19/21
 * Time: 9:28 AM
 */
const VIEW_FOLDER = "app/views/";
class Controller {
    /*
    * Creating dynamic variables
    */

    public array $variables = [];

    /*
     *
     * Used to load classes
     *
    */
    public $load;
    /*
     *
     * Input class object
     *
    */
    public Input $inputs;
    /*
     * Server Class object
     *
    */
    public Server $server;
    /*
     *
     * Cookie object
     *
    */
    public Cookies $cookie;
    /*
     *
     * Session class object
     *
    */
    public Session $session;
    /*
     *
     * Mail class object
     *
    */
    public Mail $mail;
    /*
     *
     * Model class object
     *
    */
    public stdClass|array $model = [];
    /*
     *
     * Helper class Object
     *
    */
    public stdClass|array $library = [];
    /*
     *
     * Helper
     *
    */
    public stdClass $helper;
    /*
     *
     * Controller class object
     *
    */
    public stdClass|array $controller = [];

    /*
     * Helpers object
     */

    private array $helpers = [];

    /*
     * Security helper
     */
    public Security $security;
    /*
     * Strings helper
     */
    public String_helper $strings;

    public Smarty $smarty;

    function __construct() {
        /*
         *


         * Inputs
         */
        $inputs = new Input();

        $this->inputs = $inputs;
        /*
         * Server class
         */

        $this->server = new Server();
        /*
         * Cookies class
         */
        $cookie = new Cookies();

        $this->cookie= $cookie;
        /*
         * Session class
         */
        $session = new Session();

        $this->session = $session;
        /*
         * Mail class
         */
        $this->mail = new Mail();
        /*
         * Security class
         */
        $this->security = new Security();
        /*
         * Strings class
         */
        $this->strings = new String_helper();

        $this->helper = new stdClass();
        $this->model = new stdClass();
        $this->library = new stdClass();
        $this->controller = new stdClass();
        /*
         * Load default variables
         */
        $this->assign();
        $smarty = new Smarty();
        $smarty->setTemplateDir(APP_PATH.'views/templates')
            ->setCompileDir(APP_PATH.'views/templates_c')
            ->setCacheDir(APP_PATH.'views/cache');
        $this->smarty = $smarty;
    }

    function assign($variable = '', $value = '') {
        if (! empty($variable))
            if (isset($this->variables->$variable))
                unset($this->variables->$variable);

        $assigned_data = array($variable => $value);
        array_push($this->variables, $assigned_data);
    }

    function display($file) {
        /*
         * This piece of code changes the array indices provided by the assign method to variable so that they can be accessed in the display as variables
         */
        foreach ($this->variables as $variable) extract($variable);
        /*
         *
         */

        include_once VIEW_FOLDER . $file . ".php";
        exit;
    }

    function load_view($file) {
        include_once VIEW_FOLDER . $file . ".php";
    }

    function model($class) {
        /*
         * Include and load the model classes
         * These are classes that interact with the Mysql Dal Class
         */
        include_once(APP_PATH . "models/" . $class . ".php");
        /*
         * If the class exists, create an instance of it
         */
        if (class_exists($class, true))
            $this->model->$class = new $class;
        else
            return false;
    }

    function _load_helpers() {
        /*
         * Include the helper classes from the helper library
         */
        $path = APP_PATH . "/helpers";
        $helpers = glob($path . "*.php");

    }


    function redirect($url, $header = false) {
        /*
         * Lets manage redirects
         */
        ! $header ? header("location:" . $url) : header("location:" . $url, true, $header);
        exit;
    }

    function set_headers($header, $header_value) {
        /*
         * Set Headers
         */
        header($header . ":" . $header_value);
    }

    function controller($class) {
        /*
         * Include classes from controller folder
         * ie ../app/controllers/
         *
         * By default controllers are called when they are needed
         */
        include_once(APP_PATH . "controllers/" . $class . ".php");
        /*
         * If class exists, a class instance is created
         */
        if (class_exists($class, true))
            $this->controller->$class = new $class;
        else
            return false;
    }
}

//$bpl = new Controller();