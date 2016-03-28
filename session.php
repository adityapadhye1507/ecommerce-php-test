<?php
   session_start();
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
   function __autoload($class){
 		include_once($class.".class.php");
	}
 	$db=new DB();
?>