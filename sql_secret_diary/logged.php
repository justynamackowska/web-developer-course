<?php

	session_start();

		if (array_key_exists("id", $_COOKIE))	{
          
         $_SESSION['id'] = $_COOKIE['id']; 
          
        }

		if (!array_key_exists("id", $_SESSION))	{
          
          header("Location: index.php");
          
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
		}
      	textarea {
        	margin-top:30px;  
        }
    </style>
    <title>Secret diary</title>
  </head>
  <body>
    <nav class="navbar navbar-light bg-light">
      <span class="navbar-brand mb-0 h1">Secret Diary</span>
      <form class="form-inline my-2 my-lg-0">
        <a class="btn btn-outline-success my-2 my-sm-0" href='index.php?logout=1'>Log out</a>
      </form>
    </nav>
    <form id="diary" method="post">
      <div class="container">
          <textarea class="form-control" rows="30"></textarea>
      </div>
    </form>
    
    
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>