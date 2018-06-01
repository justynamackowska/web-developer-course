<?php
	session_start();
	$error = "";
	$errorDiv = "<div class='alert alert-danger message'>There were errors in your form: ";

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
          
         $error = $errorDiv.$error."</div>"; 
          
        } else {                    
                    
            if ($_POST['signUp'] == 1) {
        
		    $query = "SELECT `id` FROM `secret-diary` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";           
           
            $result = mysqli_query($link, $query);
           
            $row = mysqli_fetch_array($result);
           
            if (mysqli_num_rows($result) > 0) {
              
             	$error = $errorDiv.$error."<p>That email address has already been taken.</p></div>";
              
            } else {
              
             	$query1 = "INSERT INTO `secret-diary` (`email`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."')";
              
                if (!mysqli_query($link, $query1)) {
                  
                  $error = $errorDiv."<p>Could not sign you up - please try again later.</p></div>";
                  
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
			  
				$error = $errorDiv.$error."<p>Invalid username and password combination.</p></div>";			  
			  
			  }             
            
      
              
            } else {
              
              $error = $errorDiv.$error."<p>Invalid username.</p></div>";
            
            }
        }
       }
    }
	
?>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style type="text/css">
		body {
			background: url(http://nanindy.com/wp-content/uploads/2017/06/cropped-ales-krivec-434.jpg) no-repeat center center fixed;
          	background-size:cover;
          	color: #FFFFFF;
		}      
        .container	{        	
        	margin-top: 150px;
        }
        #instruction	{
        	padding: 0px 10px 10px 10px;  
        }
      	#subtitle {
        	font-weight:bold;  
        }
        .form-control	{
        	 width:350px;
        }
        .message {
          	text-align:center;
          	width:350px;
          	padding:10px 10px 0px 10px;
        }
        .message-box	{
        	margin: 20px 0 2px 0;  
        }
        .btn-link	{
        	font-weight:bold;  
        }
	</style>
    <title>Secret diary</title>
  </head>
  <body>

    <div class="container">

      <h1 class="row justify-content-center">Secret Diary</h1>

      <h6 id="subtitle" class="row justify-content-center">Store your thoughts permanently and securely</h6>

       <div class="row justify-content-center message-box">
         <?php echo $error; ?>
       </div>
      
      <h6 id="instruction" class="row justify-content-center">Interested? Sign up now</h6>

        <form method="post">
                <div class="row justify-content-center">
                  <div>
                    <div class="form-group"><input type="email" class="form-control" name="email" placeholder="Your email"></div>
                    <div class="form-group"><input type="password" class="form-control" name="password" placeholder="Password"></div>
                  </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="stayLoggedIn" name="stayLoggedIn" value=1>
                      <label class="form-check-label" for="stayLoggedIn">Stay logged in</label>
                    </div>
                </div>
                <div class="form-group">
                  <input type="hidden" name="signUp" id="hiddenSignUp" value="1">
          		</div>
                <div class="row justify-content-center">
                  <div class="form-group"><input type="submit" class="btn btn-success" name="submit" id="submit" value="Sign up!"></div>
                </div>
          		<div class="row justify-content-center">
                <div><input type="text" class="btn btn-link btn-lg" id="link" value="Log in!"></div>
                </div>
	    </form>
     
 
    </div>  
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
      
      var signUp = true;
      
      $("#link").click(function()	{
        
        if (signUp)	{
         
          $("#instruction").html("Log in using your username and password");
          
          $("#submit").val("Log in!");
          
          $("#link").val("Sign up!");
          
          $("#hiddenSignUp").val(0);
          
          signUp = false;
       
        } else {
          
          $("#instruction").html("Interested? Sign up now");
          
          $("#submit").val("Sign up!");
          
          $("#link").val("Log in!");
          
          $("#hiddenSignUp").val(1);
          
          signUp = true;
          
        } 
        
      })
      
      
    </script>
  </body>
</html>    