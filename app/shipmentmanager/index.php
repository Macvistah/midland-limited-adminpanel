<?php
require_once "../database/conn.php";
	$action = $_POST['action'];
	switch ($action) {
	
	//used to manage the pickup points 
	case 'create_point':
		$name 		= e($_POST['name']);
		$charge 	= e($_POST['charge']);
		if(verifyName($name)){
			$result["success"] = "0";
			$result["message"] = "Pick up point Exists";
			echo json_encode($result);
			mysqli_close($conn); 
		}
		else{
			$query = mysqli_query($conn,"INSERT INTO pick_up_points (id,p_name,charge) VALUES(null,'$name','$charge')");
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
	break;
	case 'view_pick_up_points':
		$query = mysqli_query($conn,"SELECT * FROM pick_up_points");
		$result = array();
		$result['read'] = array();
		
		if (mysqli_num_rows($query)>0)
		{
			while ($row = mysqli_fetch_assoc($query)) {

				 $h['id']         		  = $row['id'] ;
				 $h['name']       		  = $row['p_name'] ;
				 $h['charge']       	  = $row['charge'] ;
			  
				 array_push($result["read"], $h);
			}
			$result["success"] = "1";
			echo json_encode($result);
		}

		else {
	 
		 $result["success"] = "0";
		 $result["message"] = "Error!";
		 echo json_encode($result);
		 mysqli_close($conn);
		}
	break;
	case 'edit_point':
		$id 		= $_POST['id'];
		$name 		= $_POST['name'];
		$charge 	= $_POST['charge'];

		$query = mysqli_query($conn,"UPDATE pick_up_points SET p_name = '$name',charge ='$charge' WHERE id = '$id'");
		if($query){
				$result["success"] = "0";
				$result["message"] = "Success!";
				echo json_encode($result);
			}
			else{
			$result["success"] = "2";
			$result["message"] = "Failed";
			echo json_encode($result);
			}
		
		 mysqli_close($conn);
	
	break;
	case 'view_drivers':
		$query = mysqli_query($conn,"SELECT * FROM user_tb WHERE user_type = 'driver'");
		$result = array();
		$result['read'] = array();
		
		if (mysqli_num_rows($query)>0)
		{
			while ($row = mysqli_fetch_assoc($query)) {

				 $h['id']         		  = $row['id'] ;
				 $h['name']       		  = $row['username'] ;
				 array_push($result["read"], $h);
			}
			$result["success"] = "1";
			echo json_encode($result);
		}

		else {
	 
		 $result["success"] = "0";
		 $result["message"] = "Error!";
		 echo json_encode($result);
		 mysqli_close($conn);
		}
	break;
	case 'update_shipment_details':
			$orderId = e($_POST['order_id']);
			$name  = e($_POST['driver_name']);
			$driver_id = getDriverId($name);
			$query  = mysqli_query($conn,"UPDATE shipping_details SET driver_id = '$driver_id' WHERE order_id ='$orderId'");
			if($query){
				//success
				$result["success"] = "1";
				echo json_encode($result);
			}else{
				//failed
				$result["success"] = "0";
				echo json_encode($result);
			}
			mysqli_close($conn);
		break;
	
	}
	
	
	//functions
	
	function verifyName($name){
		global $conn;
		$query = mysqli_query($conn,"SELECT id FROM pick_up_points WHERE p_name ='$name'");
		if(mysqli_num_rows($query)>0){
			return true;
		}
		else
			return false;
	}
	function getPickUpPointId($name){
		global $conn;
		$query = mysqli_query($conn,"SELECT id FROM pick_up_points WHERE p_name ='$name'");
		if(mysqli_num_rows($query)>0){
			while ($row = mysqli_fetch_assoc($query)) {
				 $id  = $row['id'] ;
			}
			return $id;
		}
		else
			return 0;
	}
	function getDriverId($name){
		global $conn;
		$query = mysqli_query($conn,"SELECT id FROM user_tb WHERE username ='$name'");
		if(mysqli_num_rows($query)>0){
			while ($row = mysqli_fetch_assoc($query)) {
				 $id  = $row['id'] ;
			}
			return $id;
		}
		else
			return 0;
	}
	
?>