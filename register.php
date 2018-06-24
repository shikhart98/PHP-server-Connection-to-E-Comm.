<?php
	require_once "connect.php";
		
		if(!$con){
			echo "Database Connection Failed";
		}else{
			if($_SERVER['HTTP_USER_AGENT'] == "Application"){
				
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					
					if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
						
						$name = $_POST['name'];
						$email = $_POST['email'];
						$password = md5($_POST['password']);
						
						$dupe = "SELECT * FROM USERS WHERE email = '$email'";
						$dupe_results = mysqli_query($con,$dupe);
						
						if(mysqli_num_rows($dupe_results)>0){
							
							echo "E-mail already exists!";
							
						}else{
							$code = rand();
							
							$sql = "INSERT INTO USERS (id, name, email, password, confirmed, code) VALUES('','$name','$email','$password','0','$code')";
							
							if(mysqli_query($con,$sql)){
								
								$from = "From: DoNotReply@application.com";
								$to = $email;
								$subject = "Application Email Verification";
								$msg = "
									$name,
									
									Please click the link below to verify your e-mail and activate your account.
									(if that does not work, copy the link and past it into your URL bar)
									
									https://radiate-round.000webhostapp.com/connect/emailver.php?email=$email&code=$code
									
									
								";
								mail($to,$subject,$msg,$from);
								echo "Please check your inbox!";
								
							}else{
								
								echo "Error: " . $sql . "<br>" . mysqli_error($con);
								
							}
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