<?php
require_once "../database/conn.php";
	$action = $_POST['action'];
	switch ($action) {
	case 'signup':
		$fname 	= e($_POST['fname']);
		$sname 	= e($_POST['sname']);
		$phone 	= e($_POST['phone_no']);
		$email 	= e($_POST['email']);
		$gender = e($_POST['gender']);
		$pass 	= e($_POST['password']);
		$user_type 	= e($_POST['user_type']);
		$username	= $fname.' '.$sname;
		$pswd 		= md5($pass);
		$status 	= 'pending';
		if(verifyEmail($email)){
			$result["success"] = "2";
			$result["message"] = "User Exists";

			echo json_encode($result);
			mysqli_close($conn);
		}
		else{
			//if email does not exist
			if($user_type == 'farmer'){
				$sql = mysqli_query($conn,"INSERT INTO farmer_tb (id,fname,sname,gender,email,phone_no) 
								VALUES (null,'$fname','$sname','$gender','$email','$phone')");
			}
			else{
				$sql = mysqli_query($conn,"INSERT INTO customer_tb (id,fname,sname,gender,email,phone_no) 
								VALUES (null,'$fname','$sname','$gender','$email','$phone')");
			}
			if($sql){
				$query = mysqli_query($conn,"INSERT INTO user_tb (id,username, email, user_type, password,status) 
						  VALUES(null,'$username', '$email', '$user_type', '$pswd','$status')");
				 if($query){
					$result["success"] = "1";
					$result["message"] = "success";
					echo json_encode($result);
					mysqli_close($conn);
				 }
				 else {
					$result["success"] = "0";
					$result["message"] = "error";

					echo json_encode($result);
					mysqli_close($conn); 
				}
			}
			 else {
					$result["success"] = "0";
					$result["message"] = "error";

					echo json_encode($result);
					mysqli_close($conn); 
				}
		}
		
	
	break;
	case 'login':
		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = mysqli_query($conn,"SELECT * FROM user_tb WHERE email='$email'");
		$result = array();
		$result['login'] = array();
		
		
		if ( mysqli_num_rows($sql) ===1 ) {
			
			$row = mysqli_fetch_assoc($sql);
			if($row['status']=='active'){

			if(md5($password) == $row['password'])  {
				
				$index['user_type']= $row['user_type'];
				$index['username'] = $row['username'];
				$index['email'] = $row['email'];
				$index['id'] = $row['id'];
				if($row['profile_pic']!=''){
				$index['photo'] = $profile_url.$row['profile_pic'];
				}
				else{
						$index['photo']="";
					}

				array_push($result['login'], $index);

				$result['success'] = "1";
				$result['message'] = "success";
				echo json_encode($result);

				mysqli_close($conn);

			} else {

				$result['success'] = "0";
				$result['message'] = "Wrong Email/Password Combination";
				echo json_encode($result);

				mysqli_close($conn);

			}
			}
			else if($row['status']=='blocked') {

				$result['success'] = "3";
				$result['message'] = "Account is disabled";
				echo json_encode($result);

				mysqli_close($conn);

			}
			else {

				$result['success'] = "4";
				$result['message'] = "Account has not been approved yet";
				echo json_encode($result);

				mysqli_close($conn);

			}
			

		}
		else{
				$result['success'] = "2";
				$result['message'] = "User Does not exist!";
				echo json_encode($result);

				mysqli_close($conn);
		}
	break;
	case 'forgot_password':
		$path = "../../";
		require'../../includes/sendmail.php';
		$email = $_POST['email'];
		$password = rand(1000,10000);
		if(verifyEmail($email)){
			$result['success'] = "1";
			$result['message'] = "Email Does Not Exists!";
			echo json_encode($result);
			mysqli_close($conn);
		}
		else{
			$to 	 = $email;
			$subject = "<b>Password Reset</b>";
			$message = "<p><b> Dear User, </b></p>
						<p> Your password has been successfully reset. Use the following password to log in
						<br/> Password:<u> ".$password."</u></p>
						<p><b>NOTE: Please change the password after log in</b></p>";
			if(updatePassword($email,$password)){
				sendMail($to,$subject,$message);
				$result['success'] = "0";
				$result['message'] = "Success!";
				echo json_encode($result);
				mysqli_close($conn);
				
			}else{
				$result['success'] = "2";
				$result['message'] = "Password Could Not be Reset!";
				echo json_encode($result);
				mysqli_close($conn);
			}
		}
	break;
	}
	
	
function verifyEmail($email){
	global $conn;
	$verify = mysqli_query($conn, "SELECT id FROM user_tb  WHERE email = '$email'");
	if(mysqli_num_rows($verify) > 0){
		return true;
	}
	else
		return false;
	}
function updatePassword($email,$password){
	global $conn;
	$pass = md5($password);
	$query = mysqli_query($conn,"UPDATE user_tb SET password = '$pass' WHERE email = '$email'");
	if($query){
		return true;
	}
	else{
		return false;
	}
}
	

?>