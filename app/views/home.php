<?php
/**
 * Created by PhpStorm.
 * User: Ashiraff
 * Company: Boosted Technologies LTD
 * Company Email: office@boostedtechs.com
 * Company Website:https://www.boostedtechs.com
 * Author's website: https://www.tumusii.me
 * Date: 7/19/21
 * Time: 9:29 AM
 */

if ( !defined('APPLICATION_LOADED') || ! APPLICATION_LOADED ) {
    echo json_encode(array("status" => "fail", "code" => "503", "message" => "Invalid request"));
}
?>
<!DOCTYPE html>
<head>
    <!-- Basic Page Needs -->
    <meta name="refresh" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boosted PHP Library</title>
    <link rel="stylesheet" href="/assets/css/bootstrap/css/bootstrap.min.css"/>
</head>
<body class="bg-light">
<div class="card col-md-8 mx-auto mt-5 shadow">
    <div class="card-header bg-transparent border-0 border-bottom">
        <h4 class="card-title"><a href="https://github.com/boosted-techs/boosted-php-library" class="text-decoration-none">Boosted PHP LIBRARY</a></h4>
    </div>
    <div class="card-body p-4">
        BPL is a PHP driven MVC developed and Maintained by <A href="https://www.boostedtechs.com">Boosted Technologies Limited.</A>
        <p>The BPL first went live in <a href="https://www.somaafrica.com">SOMAFRICA</a> in March, 2020 and later powered Boosted Technologies Website and other in-house products that needed PHP</p>
        <p>BPL is open source.</p>
        <p>BLP uses the following Third party Libraries</p>
        <div class="list-group">
            <a href="#" class="list-group-item">Smarty Templating Engine for View templating</a>
            <a href="https://github.com/joshcam/PHP-MySQLi-Database-Class" class="list-group-item">MysqliDb for Database Layer</a>
            <a href="#" class="list-group-item">Redis </a>
        </div>
        <p>To Have redis work, you will need to install redis server to your development and download the <a href="https://github.com/phpredis/phpredis">Redis PHP Extension</a></p>
        <h4>File structure / MVC structure</h4>
        <p>The MVC is subdivided into major directories where its components are placement</p>
        <ol>
            <li>APP folder
                <ol>
                    <li>Controllers: It is the controllers' folder that the controller classes that the routes call</li>
                    <li>Helpers: It contains helper files classes like session</li>
                    <li>Models: It contains the Database layer of the MVC.</li>
                    <li>Views: The front End designs take in here. The Smarty or raw PHP templates are in here
                        <ol>
                            <li>templates: It is in this folder that the .tpl files are placed.</li>
                            <li>templates_c</li>
                            <li>error</li>
                            <li>smarty-3.1.34</li>
                        </ol>
                    </li>
                </ol>
            </li>
            <li>Assets Folder. It is this folder that App assets like images, css files, js files are placed</li>
            <li>Logs. It contains app logs</li>
            <li>media. Another folder for app media files</li>
            <li>system. It contains the MVC's core code.
            <ol>
                <li>config
                <ol>
                    <li>Mailer</li>
                    <li>autoload.config.php</li>
                    <li>autoload.php</li>
                    <li>Controller_class.php</li>
                    <li>database.config.php</li>
                    <li>database.php</li>
                    <li>Db.class.php</li>
                    <li>db_object.php</li>
                    <li>index.html</li>
                    <li>inputs.php</li>
                    <li>Model_class.php</li>
                    <li>routes.php</li>
                </ol></li>
                <li>Helpers.
                <br>Files included</li>
                <ol>
                    <li>Cookie_helper.php</li>
                    <li>Inputs_helper.php</li>
                    <li>Mail_helper.php</li>
                    <li>Security.php</li>
                    <li>Server_globals_helper.php</li>
                    <li>Session_helper.php</li>
                    <li>String_helper.php</li>
                </ol>
            </ol>
            </li>
        </ol>
        <h4>Installation</h4>
        <p>To install BPL, Download or clone BPL to your webfolder from github repo <a href="https://github.com/boosted-techs/boosted-php-library">boosted-techs/boosted-php-library</a> then create a virtual host with your system.</p>
        <p>Instructions to create a virtual host</p>
        <p><a href="https://stackoverflow.com/questions/35668594/create-a-virtual-host-in-xamp-windows-10">How to create a virtual host on Windows 10 with XAMPP</a></p>
    </div>
    <div class="card-footer bg-transparent">
        <a href="https://www.boostedtechs.com" class="text-decoration-none">Boosted Technologies</a>
        | <a href="https://www.tumusii.me" class="text-decoration-none">Tumusiime - Author</a>
    </div>
</div>
</body>
</html>