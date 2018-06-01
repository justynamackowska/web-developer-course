<?php
	
	session_start();

	if (array_key_exists("content", $_POST)) {      
      
      $link = mysqli_connect("shareddb-i.hosting.stackcp.net", "secret-diary-3337e0b3", "knu52vfsef", "secret-diary-3337e0b3");
      
			if (mysqli_connect_error()) {
        
        		die ("There was an error connecting to the database");
        
    		}
      $content = mysqli_real_escape_string($link,$_POST['content']);
      
      $id = $_SESSION['id'];
      
      $query = "UPDATE `secret-diary` SET `diary` = '$content' WHERE id = '$id' LIMIT 1";
     
      mysqli_query($link, $query);
      
    }


?>