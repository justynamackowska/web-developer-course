<?php
	session_start();
	$error = "";

	if (array_key_exists("logout", $_GET))	{
      
     	unset($_SESSION['id']);
      
      	setcookie("id", "", time() - 60 * 60);
      
      	$_COOKIE["id"] = "";
      
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION["id"]) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE["id"])) {
      
     	header("Location: logged.php"); 
      
    }

	if (array_key_exists("submit", $_POST)) {
      
		$link = mysqli_connect("shareddb-i.hosting.stackcp.net", "secret-diary-3337e0b3", "knu52vfsef", "secret-diary-3337e0b3");
      
			if (mysqli_connect_error()) {
        
        		die ("There was an error connecting to the database");
        
    		}
      
      	 if (!$_POST['email']) {
            
            $error = $error."<p>Email address is required.</p>";
            
         } 
      
        if (!$_POST['password']) {
            
            $error = $error."<p>Password is required.</p>";
            
        } 
                    
        if ($error != "")	{
          
         $error = "<p>There were errors in your form: </p>".$error; 
          
        } else {                    
                    
            if ($_POST['signUp'] == 1) {
        
		    $query = "SELECT `id` FROM `secret-diary` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";           
           
            $result = mysqli_query($link, $query);
           
            $row = mysqli_fetch_array($result);
           
            if (mysqli_num_rows($result) > 0) {
              
             	$error = "<p>That email address has already been taken.</p>";
              
            } else {
              
             	$query1 = "INSERT INTO `secret-diary` (`email`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."')";
              
                if (!mysqli_query($link, $query1)) {
                  
                  $error = "<p>Could not sign you up - please try again later.</p>";
                  
                } else	{
                  
                  	$id = mysqli_insert_id($link);
              
                	$md5password = md5(md5($id).mysqli_real_escape_string($link, $_POST['password']));
              
                	$query = "UPDATE `secret-diary` SET password = '$md5password' WHERE id = '$id' LIMIT 1";
                                       
                    mysqli_query($link, $query);
                                      
                    $_SESSION['id'] = $id;
                                       
                    if (array_key_exists('stayLoggedIn',$_POST) AND $_POST['stayLoggedIn'] == 1) {
                      
                     	setcookie("id", $id, time() + 60 * 60 * 24 * 30); 
                      
                    }
                                       
                    header("Location: logged.php");
                                       
                }
              	
            }
           
         } else	{
        
		    $query = "SELECT * FROM `secret-diary` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";           
           
            $result = mysqli_query($link, $query);
          
            $row = mysqli_fetch_array($result);
          
            if (isset($row)) {
              
              $check = md5(md5($row['id']).mysqli_real_escape_string($link, $_POST['password']));
           
              if ($row['password'] ==  $check) {
                
                $_SESSION['id'] = $row['id'];
                
                if (array_key_exists('stayLoggedIn',$_POST) AND $_POST['stayLoggedIn'] == 1) {
                      
                     	setcookie("id", $row['id'], time() + 60 * 60 * 24 * 30); 
                      
                    }
                                       
                    header("Location: logged.php");
                
              } else  {
			  
				$error = $error."<p>Invalid username and password combination.</p>";			  
			  
			  }             
            
      
              
            } else {
              
              $error = $error."<p>Invalid username.</p>";
            
            }
        }
       }
    }
	
?>

<div><?php echo $error; ?></div>

<form method="post">
      <div>
        <input type="email" name="email" placeholder="Your email">
        <input type="password" name="password" placeholder="Password">
        <input type="checkbox" name="stayLoggedIn" value=1>
        <input type="hidden" name="signUp" value="1">
      	<input type="submit" name="submit" value="Sign up!">
      </div>
</form>
<form method="post">
  	  <div>
        <input type="email" name="email" placeholder="Your email">
        <input type="password" name="password" placeholder="Password">
        <input type="checkbox" name="stayLoggedIn" value=1>
        <input type="hidden" name="signUp" value="0">
      	<input type="submit" name="submit" value="Log in!">
      </div>
      
</form>  
          