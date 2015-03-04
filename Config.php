<?php

include "Database.php";
include "Pagination.php";
include "Player.php";
include "Leaderboard.php";
include "simple_html_dom.php";

//Timezone
date_default_timezone_set('UTC');
//Session
if(!isset($_SESSION)) session_start();
ini_set('default_charset', 'utf-8');

//Cache
//phpFastCache::setup("storage","auto");
//$cache = phpFastCache();

//Admin
// Set a MD5 encoded password below (just for utilities)
$admin = "HACKME";
$admin=($admin == md5($_GET['passwd']))?true:false;

//Params
// This param is used to debug the code
$debug = ($_GET['debug'])?true:false;
if($debug) {error_reporting(E_ALL);}

// A long time ago, AN was using splited leaderboard (solo and team), and now it's gone
$mode = "pvp";

//Database
// Configure your database settings below
define("DBTYPE","mysql");
define("DBHOST","localhost");
define("DBNAME","gw2br_leaderboard");
define("DBUSER","gw2br");
define("DBPASS","HACKME");
$leaderboard = Leaderboard::getInstance();
$leaderboard->setMode($mode);

//Other (change this only when AN changes leaderboard code)
define("ANET_PAGES",40);
define("ANET_URL","https://leaderboards.guildwars2.com/en/na/$mode?pajax=1");

// DO NOT CHANGE THE SETTINGS BELOW

//Pagination, (pagination is not working yet)
 /*** set the page name ***/
 $page_name = htmlentities($_SERVER['PHP_SELF']);
 /*** set the number of results per page ***/
 $limit = 20;
 /*** check the SESSION array for the total_records ***/
 if(!isset($_SESSION['total_records'])) { $_SESSION['total_records'] = $leaderboard->count(); }
 /*** check for a page number in GET ***/
 if( filter_has_var(INPUT_GET, "page") == false)
 {
    /*** no page in GET ***/
    $page = 1;
 }
 /*** if the page number is not an int or not within range, assign it to page 1 ***/
 elseif(filter_var($_GET['page'], FILTER_VALIDATE_INT, array("min_range"=>1, "max_range"=>$_SESSION['total_records'])) == false)
 {
    $page = 1;
 } else {
    /*** if all is well, assign it ***/
    $page = (int)$_GET['page'];
 }
 /*** feed the variables to the pagination class ***/
 $pagination = new Pagination($_SESSION['total_records'], $limit, $page);
 $pagination->menu_link = "?";
 if($debug) $pagination->menu_link = $pagination->menu_link . "&debug=true";

//Captcha
// creates a SESSION with the sum of two numbers. Receives the session name
// returns an array with the two numbers
// From: // http://coursesweb.net/php-mysql/
function setCaptcha($ses_name) {
  $nrs = array(mt_rand(1, 50), rand(1, 50));      // array with 2 random numbers, between 1 and 50

  // if session exists, delete it, sets session with the sum of $nrs[0] and $nrs[1]
  if(isset($_SESSION[$ses_name])) { unset($_SESSION[$ses_name]); }
  $_SESSION[$ses_name] = $nrs[0] + $nrs[1];

  return $nrs;        // returns the array with the numbers
}