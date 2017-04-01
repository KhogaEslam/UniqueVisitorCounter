<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("dbcon.php");

function getUserLanguage(){
  if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
      $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
      $lang = substr($lang, 0, 2);
      return $lang;
    }
    else {
      return NULL;
    }
}

function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    // var_dump($_SERVER);
    // exit;
    return $ip;
}

function getCounterFromFile(){
  $counter = file_get_contents("UniqueVisitorCounter.txt");
  $counter = trim($counter);
  return $counter;
}

function writeToFile($counter){
  $visitorsFile = fopen("UniqueVisitorCounter.txt","w+");
  fwrite($visitorsFile,$counter);
  fclose($visitorsFile);
}

function UniqueVisitorCounter(){
  $ip = getRealIpAddr();
  $counter = getCounterFromFile();
  $visit = "new";
  if(isset($_SESSION['currentUserIP']))
  {
    $visit = "current";
  }
  else
  {
    $_SESSION['currentUserIP'] = $ip;
    $dbHelper = new DatabaseHelper();
    $flag = $dbHelper->checkExist($ip);
    if($flag){
      $visit = "return";
    }
    else{
      $counter = $counter + 1;
      writeToFile($counter);
    }
  }
  $userLang = getUserLanguage();
  printUserOutput($userLang, $counter, $visit);
}

function printUserOutput($userLang, $counter, $visit){
  switch ($userLang){
    case "fr":
        //echo "PAGE FR";
        if($visit == "current"){
          echo "[in $userLang] Your Session is still UP! ... current unique users counter is $counter";
        }
        elseif($visit == "return"){
          echo "[in $userLang] Welcome Back! ... current unique users counter is $counter";
        }
        else{
          echo "[in $userLang] Welcome to our site, you are unique visitor number $counter";
        }
        break;
    case "it":
        //echo "PAGE IT";
        if($visit == "current"){
          echo "[in $userLang] Your Session is still UP! ... current unique users counter is $counter";
        }
        elseif($visit == "return"){
          echo "[in $userLang] Welcome Back! ... current unique users counter is $counter";
        }
        else{
          echo "[in $userLang] Welcome to our site, you are unique visitor number $counter";
        }
        break;
    case "en":
        //echo "PAGE EN";
        if($visit == "current"){
          echo "[in $userLang] Your Session is still UP! ... current unique users counter is $counter";
        }
        elseif($visit == "return"){
          echo "[in $userLang] Welcome Back! ... current unique users counter is $counter";
        }
        else{
          echo "[in $userLang] Welcome to our site, you are unique visitor number $counter";
        }
        break;
    case "ar":
        //echo "PAGE EN";
        if($visit == "current"){
          echo "[in $userLang] Your Session is still UP! ... current unique users counter is $counter";
        }
        elseif($visit == "return"){
          echo "[in $userLang] Welcome Back! ... current unique users counter is $counter";
        }
        else{
          echo "[in $userLang] Welcome to our site, you are unique visitor number $counter";
        }
        break;
    default:
        //echo "PAGE EN - Setting Default";
        if($visit == "current"){
          echo "[in Default $userLang] Your Session is still UP! ... current unique users counter is $counter";
        }
        elseif($visit == "return"){
          echo "[in Default $userLang] Welcome Back! ... current unique users counter is $counter";
        }
        else{
          echo "[in Default $userLang] Welcome to our site, you are unique visitor number $counter";
        }
        break;
  }
}
