<?php 
  session_start();

  echo "<!DOCTYPE html>\n<html><head>";

  require_once 'db_connect.php';	//DataBase Connection

  $userstr = ' (Guest)';

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;

  echo "<title>E-Mall</title><link rel='stylesheet' ".
       "href='styles.css' type='text/css'>".
       "<script src='javascript.js'></script>";

 ?>
