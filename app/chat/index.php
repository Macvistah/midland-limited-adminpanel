<?php /** @noinspection ALL */
require_once "../database/conn.php";
$action = $_GET['action'];
$results = [];

switch ($action) {
    case 'send_message':
        $userId= isset($_POST['user_id']) ? e($_POST['user_id']) : null;
        $recipientId  = isset($_POST['recipient_id']) ? e($_POST['recipient_id']) : null;
        $message = isset($_POST['message']) ? e($_POST['message']) : null;

        if (!$userId || !$recipientId || !$message){
            $result["success"] = "0";
            $result["message"] = "Could not send message.Try again!";
            echo json_encode($result);
            mysqli_close($conn);
            return;
        }
        $sql = "INSERT into chat_tb (sender_id, recipient_id, message) VALUES ('$userId','$recipientId', '$message')";

        $query  = mysqli_query($conn,$sql);
        if($query){
            $result["success"] = "1";
            $result["message"] = "Message sent successfully!";
            echo json_encode($result);
        }

        mysqli_close($conn);
        break;
    case 'view_chats':
        $userId= isset($_POST['user_id']) ? e($_POST['user_id']) : null;
        $recipientId  = isset($_POST['recipient_id']) ? e($_POST['recipient_id']) : null;

        $result["read"] = [];

        $sql = "SELECT c.*, u.username, u.email
                    FROM chat_tb AS c
                    JOIN user_tb AS u ON  (c.sender_id = u.id OR c.recipient_id = u.id)
                    WHERE (COALESCE('$userId', '') = '' OR c.sender_id = '$userId' OR c.sender_id = '$recipientId')
                        AND  (COALESCE('$recipientId', '') = '' OR c.recipient_id = '$recipientId' OR c.recipient_id = '$userId' )
                        AND u.id != '$userId'
                        AND c.deleted_on IS NULL";
        $query = mysqli_query($conn, $sql);
        try{
            if ($query === false) {
                // Query execution failed
                $result["success"] = "0";
                $result["message"] = "Query execution failed: " . mysqli_error($conn);
                echo json_encode($result);
                return;
            }
            if(mysqli_num_rows($query)>0){
                while($row = mysqli_fetch_assoc($query)){
                    $h['id'] 			  	 = $row['id'];
                    $h['recipient_name'] 	 	 	 = $row['username'];
                    $h['recipient_id'] 	 	 	 = $row['recipient_id'];
                    $h['sender_id'] 	 	 	 = $row['sender_id'];
                    $h['message'] 	 	 	 = $row['message'];
//                $h['deleted'] 	 	 	 = $row['prod_name'];
                    $h['date']	 	 	     = date('d/m/Y H:i',strtotime($row['created_on']));
                    $h['status'] 	     	 = $row['status'];
                    array_push($result["read"], $h);
                }
                $result["success"] = "1";
                echo json_encode($result);
            }else{
                //no records found
                $result["success"] = "0";
                $result["message"] = "No records found";
                echo json_encode($result);
            }
        }catch (mysqli_sql_exception $e){
            $result["success"] = "0";
            $result["message"] = "An error occured!";
            echo json_encode($result);
        }
        mysqli_close($conn);

        break;
    case 'view_contacts':
        $userId= isset($_POST['user_id']) ? e($_POST['user_id']) : null;

        $result["read"] = [];

        $sql = "SELECT  u.id, u.username, u.user_type, u.created_on, u.profile_pic
                    FROM user_tb AS u
                    WHERE u.user_type != 'customer' AND u.user_type != 'supplier'
                     ORDER BY
                        u.user_type ASC;
                    ";
        $query = mysqli_query($conn, $sql);
        try{
            if ($query === false) {
                // Query execution failed
                $result["success"] = "0";
                $result["message"] = "Query execution failed: " . mysqli_error($conn);
                echo json_encode($result);
                return;
            }
            if(mysqli_num_rows($query)>0){
                while($row = mysqli_fetch_assoc($query)){
                    $h['sender_id'] 			  	 = $row['id'];
                    $h['recipient_name'] 	 	 	 = $row['username'];
                    $h['recipient_id'] 	 	 	 = $row['id'];
                    $h['recipient_type'] 	 	 	 = strtoupper($row['user_type']);
                    $h['message'] 	 	 	 = "";
                    $h['photo'] 	 	 	 = $row['profile_pic']!='' ? $profile_url.$row['profile_pic'] : null;
                    $h['date']	 	 	     = date('d/m/Y H:i',strtotime($row['created_on']));
                    $h['status'] 	     	 = $row['status'];
                    array_push($result["read"], $h);
                }
                $result["success"] = "1";
                echo json_encode($result);
            }else{
                //no records found
                $result["success"] = "0";
                $result["message"] = "No records found";
                echo json_encode($result);
            }
        }catch (mysqli_sql_exception $e){
            $result["success"] = "0";
            $result["message"] = "An error occured!";
            echo json_encode($result);
        }
        mysqli_close($conn);

        break;
    case 'view_chat_contacts':
        $userId= isset($_POST['user_id']) ? e($_POST['user_id']) : null;
        $result["read"] = [];

        $sql = "SELECT DISTINCT
                u.id,
                u.username,
                u.email,
                u.profile_pic,
                u.user_type,
                (
                    SELECT ch.message
                    FROM chat_tb as ch
                    WHERE (ch.sender_id = u.id AND ch.recipient_id = '$userId' OR ch.sender_id = '$userId' AND ch.recipient_id = u.id)
                        AND ch.deleted_on IS NULL
                    ORDER BY ch.created_on DESC
                    LIMIT 1
                ) AS last_message,
                (
                    SELECT ch.sender_id
                    FROM chat_tb as ch
                    WHERE (ch.sender_id = u.id AND ch.recipient_id = '$userId' OR ch.sender_id = '$userId' AND ch.recipient_id = u.id)
                        AND ch.deleted_on IS NULL
                    ORDER BY ch.created_on DESC
                    LIMIT 1
                ) AS sender_id,
                (
                    SELECT ch.status
                    FROM chat_tb as ch
                    WHERE (ch.sender_id = u.id AND ch.recipient_id = '$userId' OR ch.sender_id = '$userId' AND ch.recipient_id = u.id)
                        AND ch.deleted_on IS NULL
                    ORDER BY ch.created_on DESC
                    LIMIT 1
                ) AS last_status,
                (
                    SELECT MAX(ch.created_on)
                    FROM chat_tb as ch
                    WHERE (ch.sender_id = u.id AND ch.recipient_id = '$userId' OR ch.sender_id = '$userId' AND ch.recipient_id = u.id)
                        AND ch.deleted_on IS NULL
                ) AS last_date
            FROM
                user_tb AS u
            LEFT JOIN chat_tb AS c ON (u.id = c.recipient_id OR u.id = c.sender_id)
            WHERE
                ('$userId' IS NULL OR c.sender_id = '$userId' OR c.recipient_id = '$userId')
                AND c.deleted_on IS NULL
                AND u.id != '$userId'  -- Exclude the user with the specified ID
            ORDER BY
                last_date DESC;
            ;";

        $query = mysqli_query($conn, $sql);
        try{
            if ($query === false) {
                // Query execution failed
                $result["success"] = "0";
                $result["message"] = "Query execution failed: " . mysqli_error($conn);
                echo json_encode($result);
                return;
            }
            if(mysqli_num_rows($query)>0){
                while($row = mysqli_fetch_assoc($query)){
                    $h['sender_id'] 			  	 = $row['sender_id'];
                    $h['recipient_name'] 	 	 	 = $row['username'];
                    $h['recipient_id'] 	 	 	 = $row['id'];
                    $h['recipient_type'] 	 	 	 = strtoupper($row['user_type']);
                    $h['message'] 	 	 	 = $row['last_message'];
                    $h['photo'] 	 	 	 = $row['profile_pic']!='' ? $profile_url.$row['profile_pic'] : null;
                    $h['date']	 	 	     = date('d/m/Y H:i',strtotime($row['last_date']));
                    $h['status'] 	     	 = $row['last_status'];
                    array_push($result["read"], $h);
                }
                $result["success"] = "1";
                echo json_encode($result);
            }else{
                //no records found
                $result["success"] = "0";
                $result["message"] = "No records found";
                echo json_encode($result);
            }
        }catch (mysqli_sql_exception $e){
            $result["success"] = "0";
            $result["message"] = "An error occured!";
            echo json_encode($result);
        }
        mysqli_close($conn);

        break;
    case 'update_status':
        $userId= isset($_POST['user_id']) ? e($_POST['user_id']) : null;
        $recipientId  = isset($_POST['recipient_id']) ? e($_POST['recipient_id']) : null;

        if (!$userId || !$recipientId){
            $result["success"] = "0";
            $result["message"] = "Could not send message.Try again!";
            echo json_encode($result);
            mysqli_close($conn);
            return;
        }

        $sql = "UPDATE chat_tb SET status = 'READ' WHERE sender_id='$userId' AND recipient_id='$recipientId'";

        $query = mysqli_query($conn, $sql);

        if ($query){
            $result['status'] = "1";
            $result['message'] = "Status updated successfully!";
        }
        else{
            $result['status'] = "0";
            $result['message'] = "Could not update status! Try Again";
            $result["error"] = "Query execution failed: " . mysqli_error($conn);
        }
        echo json_encode($result);

        mysqli_close($conn);
        break;
    case 'delete_message':
        $id = isset($_POST['id']) ? e($_POST['id']) : null;

        if (!$id){
            $result["success"] = "0";
            $result["message"] = "Please provide ID!";
            echo json_encode($result);
            mysqli_close($conn);
            return;
        }

        $date = date('Y-m-d H:i:s');

        $sql = "UPDATE chat_tb SET deleted_on = '$date' WHERE id='$id' ";

        $query = mysqli_query($conn, $sql);

        if ($query){
            $result['status'] = "1";
            $result['message'] = "Message deleted successfully!";
        }
        else{
            $result['status'] = "0";
            $result['message'] = "Could not delete message! Try Again";
            $result["error"] = "Query execution failed: " . mysqli_error($conn);
        }
        echo json_encode($result);

        mysqli_close($conn);
        break;
}

?>
