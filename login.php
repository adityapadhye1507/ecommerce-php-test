<?php
	require_once("DB.class.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $user = $_POST['username'];
      $pass = $_POST['password']; 
      
      $db = new DB();
      $validUser = $db->isValidUser($user,$pass);
      if($validUser){
        $_SESSION['login_user'] = $user;
      	$adminUser = $db->isAdminUser($user);
      	if($adminUser){
      		$_SESSION['admin_user'] = true;
      		header("location: admin.php");
      	} else{
      		header("location: index.php");
      	}
      }
      else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<!DOCTYPE HTML>
<html>
   
   <head>
      <title>Login Page</title>
       <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
   </head>
   
   <body>
	
      <div class="container">
         <div class="form-group">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form class="well" action = "login.php" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit " class="btn"/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>