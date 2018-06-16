<?php
/*
 * 
 * All the configurations for the project go here
 */
 
define('BASE_PATH','http://localhost/phpquiz/');
define('DB_HOST', 'localhost');
define('DB_NAME', 'mcqforum');
define('DB_USER','root');
define('DB_PASSWORD','theanimalfarm');



/** Development Environment **/
// when Set to false, no error will be throw out, but saved in temp/log.txt file.
define ('DEVELOPMENT_ENVIRONMENT',true);

/** Site Root **/
// Domain name of the site (no slash at the end!)
//define('SITE_ROOT' , 'http://You domain name');
define('SITE_ROOT' , 'http://localhost');

// Default controller and action on landing
define ('DEFAULT_CONTROLLER', "index");
define ('DEFAULT_ACTION', "index");

// No of questions per page
define('QUESTIONS_PER_PAGE',5);

