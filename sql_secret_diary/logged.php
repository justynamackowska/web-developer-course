<?php

	session_start();

	$diaryContent = "";

		if (array_key_exists("id", $_COOKIE))	{
          
         $_SESSION['id'] = $_COOKIE['id']; 
          
        }

		if (array_key_exists("id", $_SESSION) && $_SESSION['id'])	{
          
         $link = mysqli_connect("shareddb-i.hosting.stackcp.net", "secret-diary-3337e0b3", "knu52vfsef", "secret-diary-3337e0b3");
      
			if (mysqli_connect_error()) {
        
        		die ("There was an error connecting to the database");
        
    		} 
          
          $id = $_SESSION['id'];
          
          $query = "SELECT diary FROM `secret-diary` WHERE id = '$id' LIMIT 1";
          
          $row = mysqli_fetch_array(mysqli_query($link, $query));
          
          $diaryContent = $row['diary'];
          
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
    <div class="container-fluid">
            <textarea id="diary" class="form-control" rows="30"><?php echo $diaryContent; ?></textarea>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script type="text/javascript">
    
  $('#diary').bind('input propertychange', function() {
     	 $.ajax({
         	method: "POST",
            url: "updatedatabase.php",
            data: { content: $("#diary").val()}
           });
        
	});
    
    
    
    </script>
  </body>
</html>