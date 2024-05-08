<?php
require_once "../database/conn.php";
$action = $_POST['action'];
switch ($action) {

    case 'send_message':
        $userId      = e($_POST['id']);
        $from 	 	 = e($_POST['email']);
        $subject 	 = e($_POST['subject']);
        $message     = e($_POST['message']);
        $status 	 ="unread";

        $query = mysqli_query($conn,"INSERT INTO feedback_tb(id,user_id,email,status,subject,message) 
										VALUES(null,'$userId','$from','$status','$subject','$message')");
        if($query){
            $result["success"] = "1";
            $result["message"] = "success";
            echo json_encode($result);
        }
        else{
            $result["success"] = "0";
            $result["message"] = "Failed";
            echo json_encode($result);
        }
        break;
    case 'view_account':
        $email 		= e($_POST['email']);
        $userType	= e($_POST['user_type']);
        $result = array();
        $result['read'] = array();

        if ($userType === 'supplier'){
            $query = mysqli_query($conn,"SELECT * FROM supplier_tb WHERE contact_email = '$email'");
            if ( mysqli_num_rows($query) ===1 ) {
                $row = mysqli_fetch_assoc($query);
                $index['fname']	= $row['contact_fname'];
                $index['sname']	= $row['contact_sname'];
                $index['gender']= $row['contact_gender'];
                $index['phone']= $row['contact_phone'];
                $index['email']= $row['contact_email'];

                array_push($result['read'], $index);
                $result['success'] = "1";
                $result['message'] = "success";
                echo json_encode($result);

                mysqli_close($conn);

            }else {
                //nothing found.
                $result['success'] = "0";
                $result['message'] = "Failed";
                echo json_encode($result);
            }
        }
        else{
            $query = mysqli_query($conn, "SELECT * FROM " . getTable($userType) . " WHERE email = '$email'");
            if (mysqli_num_rows($query) === 1) {
                $row = mysqli_fetch_assoc($query);
                $index['fname'] = $row['fname'];
                $index['sname'] = $row['sname'];
                $index['gender'] = $row['gender'];
                $index['phone'] = $row['phone_no'];
                $index['email'] = $row['email'];

                array_push($result['read'], $index);
                $result['success'] = "1";
                $result['message'] = "success";
                echo json_encode($result);

                mysqli_close($conn);

            } else {
                //nothing found.
                $result['success'] = "0";
                $result['message'] = "Failed";
                echo json_encode($result);
            }
        }
        mysqli_close($conn);
        break;

    case 'update_profile':
        $id  	 	   = e($_POST['id']);
        $userType	   = e($_POST['user_type']);
        $fname 	 	   = e($_POST['fname']);
        $sname 	 	   = e($_POST['sname']);
        $email 	 	   = e($_POST['email']);
        $initial_email = e($_POST['initial_email']);
        $phone   	   = e($_POST['phone']);
        $gender   	   = e($_POST['gender']);
        $userName      = $fname." ".$sname;


        if(updateUser($id , $userName, $email)){
            //get usertype to define which table to modify
            $query = mysqli_query($conn,"UPDATE ".getTable($userType)." SET fname = '$fname' ,sname = '$sname' ,email = '$email' ,phone_no = '$phone', gender = '$gender' 
											WHERE email = '$initial_email'");
            if($query){
                $result["success"] = "1";
                $result["message"] = "success";
                echo json_encode($result);
                mysqli_close($conn);
            }
            else{
                $result["success"] = "2";
                $result["message"] = "Failed";
                echo json_encode($result);
                mysqli_close($conn);
            }
        }
        else{
            $result["success"] = "0";
            $result["message"] = "Account with the same Email exists";
            echo json_encode($result);
            mysqli_close($conn);
        }

        break;
    case 'upload_image':
        $id 	 = e($_POST['id']);
        $image	 = $_POST['image'];

        $image_name = rand()."_".time().".jpeg";
        $path = "../../uploads/profile_pics/".$image_name;

        $query = mysqli_query($conn,"UPDATE user_tb SET profile_pic = '$image_name' WHERE id = '$id'");
        if($query){
            file_put_contents( $path, base64_decode($image));
            $result["path"]    = $profile_url.$image_name;
            $result["success"] = "1";
            $result["message"] = "success";
            echo json_encode($result);
        }
        else{
            $result["success"] = "0";
            $result["message"] = "Failed";
            echo json_encode($result);

        }
        mysqli_close($conn);
        break;

    case 'reset_password':
        $id  	     = e($_POST['id']);
        $currentPsw  = e($_POST['current_psw']);
        $newPsw  	 = e($_POST['new_psw']);
        if(confirmPassword($id,$currentPsw)){
            //change password
            $pass = md5($newPsw);
            $query = mysqli_query($conn,"UPDATE user_tb SET password = '$pass' WHERE id = '$id'");
            if($query){
                $result["success"] = "1";
                $result["message"] = "Success";
                echo json_encode($result);
            }
            else{
                $result["success"] = "2";
                $result["message"] = "Failed";
                echo json_encode($result);
            }
        }
        else{
            $result["success"] = "0";
            $result["message"] = "Password does not match";
            echo json_encode($result);
        }
        mysqli_close($conn);
        break;
}
function verifyEmail($email){
    global $conn;
    $verify = mysqli_query($conn, "SELECT id FROM user_tb  WHERE email = '$email'");
    if(mysqli_num_rows($verify) > 1){
        return true;
    }
    else
        return false;
}
function getTable($user_type){
    if($user_type == "customer"){
        return "customer_tb";
    }
    else{
        return "employee_tb";
    }
}
function updateUser($id,$userName,$email){
    global $conn;
    $query = mysqli_query($conn,"UPDATE user_tb SET username = '$userName', email = '$email' WHERE id = '$id'");
    if($query){
        return true;
    }
    else {
        return false;
    }
}
function confirmPassword($id , $current_psw){
    global $conn;
    $pass = md5($current_psw);
    $query = mysqli_query($conn,"SELECT id FROM user_tb WHERE id = '$id' AND password = '$pass'");
    if(mysqli_num_rows($query) === 1){
        return true;
    }
    else{
        return false;
    }
}
function sendOTP($email){

}

?>