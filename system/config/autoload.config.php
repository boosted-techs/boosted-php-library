<?php
include_once(SYSTEM_PATH."config/routes.php");
include_once ("autoload.php");
include_once ("database.config.php");

//Loading smarty templating engine
define ("SYS_DIR", "views/smarty-3.1.34/libs/");
//die();
require_once (APP_PATH.SYS_DIR."Smarty.class.php");


foreach ($inputs as $file_path => $input_class) {
    include_once($file_path . ".php");
}

class Controller {
    public $smarty; //Smarty class

    public $load; //Load class

    public $input; //Input class

    public $server; //Server class

    public $cookie; //Cookie class

    public $session; //Session class

    public $mail; //mail class

    public $model = [];

    public $library = [];

    public $helper = [];

    public $controller = [];

    function __construct() {
        //parent::__construct();
        //Loading smarty
        $smarty = new Smarty();
        $smarty->setTemplateDir(APP_PATH.'views/templates')
            ->setCompileDir(APP_PATH.'views/templates_c')
            ->setCacheDir(APP_PATH.'views/cache');
        $this->smarty = $smarty;

        //Loading models

        //Input class
        $this->input = new Input();
        //Server class
        $this->server = new Server();
        //cookie class
        $this->cookie = new Cookies();
        //Session class
        $this->session = new Session();
        //Mail class
        $this->mail = new Mail();

        $this->helper = new stdClass();
        $this->model = new stdClass();
        $this->library = new stdClass();
        $this->controller = new stdClass();
    }

    function model($class) {
        include_once(APP_PATH."models/" . $class . ".php");
        if (class_exists($class, true))
            $this->model->$class = new $class;
    }


    function redirect($url) {
        header("location:".$url);
        exit;
    }

    function controller($class) {
        include_once(APP_PATH."controllers/" . $class . ".php");
        if (class_exists($class, true))
            $this->controller->$class = new $class;
    }

    function class_load_error($error) {
        $smarty = $this->smarty();
        $smarty->assign("error", $error);
        $smarty->display("./error/error.tpl");
    }

    function remove_none_utf_char($string) {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $string);
    }

    function remove_special_chars($string) {
        $string = strip_tags($string);
        $string = preg_replace('/[^A-Za-z0-9. -]/', ' ', $string);
        // Replace sequences of spaces with hyphen
        $string = preg_replace('/  */', '-', $string);
        return $string;
    }

    function xss_clean($string) {
        $string = strip_tags($string);
        return $string;
    }

    function remove_numbers_from_string($string) {
        return preg_replace('/\d+/u', '', $string);
    }

    function replace_multiple_spaces($string) {
        return preg_replace('!\s+!', ' ', $string);
    }
}

class Model extends Controller {
    public $db;
    function __construct(){
        parent::__construct();
        //Db config
        global $database_config;
        $this->db = new MysqliDb($database_config['host'], $database_config['username'], $database_config['password'], $database_config['database']);
    }

    public function password_hash($string) {
        return hash('sha256', $string);
    }
}