<?php
	session_start();
	if (array_key_exists('email1', $_POST) OR array_key_exists('password1', $_POST)) {
      
		$link = mysqli_connect("shareddb-i.hosting.stackcp.net", "secret-diary-3337e0b3", "knu52vfsef", "secret-diary-3337e0b3");
      
			if (mysqli_connect_error()) {
        
        		die ("There was an error connecting to the database");
        
    		}
      
      	 if ($_POST['email1'] == '' AND $_POST['password1'] != '') {
            
            echo "<p>Email address is required.</p>";
            
        } else if ($_POST['email1'] != '' AND $_POST['password1'] == '') {
            
            echo "<p>Password is required.</p>";
            
        } else if ($_POST['email1'] != '' AND $_POST['password1'] != '') {
        
		    $query = "SELECT `id` FROM `secret-diary` WHERE email = '".mysqli_real_escape_string($link, $_POST['email1'])."'";           
           
            $result = mysqli_query($link, $query);
           
            $row = mysqli_fetch_array($result);
           
            if (mysqli_num_rows($result) > 0) {
              
             	echo  "<p>That email address has already been taken.</p>";
              
            } else {
              
             	$query1 = "INSERT INTO `secret-diary` (`email`) VALUES ('".mysqli_real_escape_string($link, $_POST['email1'])."')";
              
                mysqli_query($link, $query1);
              
                $query2 = "SELECT `id` FROM `secret-diary` WHERE email = '".mysqli_real_escape_string($link, $_POST['email1'])."'";
              
                $result = mysqli_query($link, $query2);
              
                $row = mysqli_fetch_array($result);
              
                $key = $row['id'];
              
                $md5password = md5(md5($row['id']).mysqli_real_escape_string($link, $_POST['password1']));
              
                $query3 = "UPDATE `secret-diary` SET password = '$md5password' WHERE id = '$key' LIMIT 1";
              	
              	if (mysqli_query($link, $query3)) {
                  
                  $_SESSION['email'] = $_POST['email1'];
                  
                  header ("Location: session.php");
                  
                } else {
                 
                  echo "<p>There was a problem signing you up - please try again later.</p>";
                  
                }
            }
           
         } else if ($_POST['email2'] == '' AND $_POST['password2'] != '') {
            
            echo "<p>Email address is required.</p>";
            
        } else if ($_POST['email2'] != '' AND $_POST['password2'] == '') {
            
            echo "<p>Password is required.</p>";
            
        } else if ($_POST['email2'] != '' AND $_POST['password2'] != '') {
        
		    $query = "SELECT * FROM `secret-diary` WHERE email = '".mysqli_real_escape_string($link, $_POST['email2'])."'";           
           
            $result = mysqli_query($link, $query);
          
            $row = mysqli_fetch_array($result);
           
            $check = md5(md5($row['id']).mysqli_real_escape_string($link, $_POST['password2']));
           
            if ($row['password'] ==  $check) {
              
              if (empty($_POST['stayLogged']))	{
                
               	 $_SESSION['email'] = $_POST['email2'];
                  
                 header ("Location: logged.php");
                
              } else	{
                
                setcookie("email", $_POST['email2'], time() + 60 * 60 * 24 * 7);
                
              	if ($_COOKIE['email'])	{
              
              		header("Location: logged.php");
                }
              }
      
              
            } else {
              
              echo "<p>Invalid username or password.</p>";
            
            }
         }
    }
	
?>
<form method="post">
      <div>
        <input type="text" name="email1" placeholder="Your email">
        <input type="password" name="password1" placeholder="Password">
        <input type="checkbox" name="staySigned" value="Yes">
      	<input type="submit" id="button1" value="Sign up!">
      </div>
  	  <br>
  	  <div>
        <input type="text" name="email2" placeholder="Your email">
        <input type="password" name="password2" placeholder="Password">
        <input type="checkbox" name="stayLogged" value="Yes">
      	<input type="submit" id="button2" value="Log in!">
      </div>
      
 </form>  