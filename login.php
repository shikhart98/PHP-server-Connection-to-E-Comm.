<?php

	require_once "connect.php";
	
	if(!$con){
			echo "Database Connection Failed";
	}else{
				if($_SERVER['HTTP_USER_AGENT'] == "Application"){
					
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						
						if(isset($_POST['email']) && isset($_POST['password'])){
							
							$email = $_POST['email'];
							$password = md5($_POST['password']);
							
							$dupe = "SELECT * FROM USERS WHERE email = '$email'";
							$dupe_results = mysqli_query($con,$dupe);
							
							if(mysqli_num_rows($dupe_results)> 0){
								
								$qry = "SELECT * FROM USERS WHERE email = '$email' and password = '$password'";
								$qry_result = mysqli_query($con,$qry);
									if(mysqli_num_rows($qry_result)>0){
										echo "You are successfully logged in!";
									}else{
										echo "Incorrect Email/Password.";
									}
									
							}else{
								
								echo "Email is not registered.Please Sign Up first!";
								
							}
							
							
							mysqli_close($con);
							
						}else{
							
							echo "Missing Required Fields!";
							
						}
						
					}else{
						
						echo "Improper request method";
						
					}
					
				}else{
					
					echo "Invalid Platform!";
					
				}	
			
		}

?>