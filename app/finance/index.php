<?php
require_once "../database/conn.php";
	$action = $_POST['action'];
	//$action = 'view_orders';
	switch ($action) {
		case 'view_orders':	
			$result = array();
			$result['read'] = array();
			$query  = mysqli_query($conn,"SELECT * FROM order_tb WHERE status != 'Cancelled'");
			
			if(mysqli_num_rows($query)>0){
				while($row = mysqli_fetch_assoc($query)){
					
					$h['id'] 			  	 = $row['id'];
					$h['order_no'] 	 	 	 = $row['order_no'];
					$h['total_amount'] 	     = $row['total_amount'];
					
					
					if($row['payment_id']== null){
						array_push($result["read"], $h);
					}
					
						
				}
				$result["success"] = "1";
				echo json_encode($result);
			}else{
				//no records found
				$result["success"] = "0";
				echo json_encode($result);
			}
			mysqli_close($conn);
		break;
		case 'create_payment':
			$orderNo 		= e($_POST['order_no']);
			$amount 		= e($_POST['amount']);
			$mode 			= e($_POST['mode']);
			$paid_by 		= e($_POST['name']);
			$transaction  	= strtoupper(substr("TNO", 0, 4)).date("ym").rand(pow(10,3), pow(10,2));
			
			if(verifyOrderNo($orderNo)){
				//if true then
				$paymentId = createPaymentRecord($amount,$mode,$paid_by,$transaction);
				if($paymentId >0){
					//update the order payment status
					if(updateOrderPayment($orderNo,$paymentId)){
						$result["success"] = "1";
						echo json_encode($result);
					}else{
						$result["success"] = "0";
						echo json_encode($result);
					}	
				}
				else{
					//record was not created
				$result["success"] = "2";
				echo json_encode($result);
				}
			}
			else{
				//order no does not exist
				$result["success"] = "3";
				echo json_encode($result);
			}
			
		
		break;
		case 'read_records':
		$query = mysqli_query($conn,"SELECT * FROM payment_tb order by created_on DESC");
		$result = array();
		$result['read'] = array();
		
		if (mysqli_num_rows($query)>0)
		{
			while ($row = mysqli_fetch_assoc($query)) {

				 $h['id']         		  		  = $row['payment_id'] ;
				 $h['transaction_no']     		  = $row['transaction_no'];
				 $h['payment_mode']       		  = $row['payment_mode'];
				 $h['amount']       		  	  = $row['amount'];
				 $h['paid_by']       	  		  = $row['paid_by'];
				 $h['created_on']       		  = date('d/m/Y', strtotime($row['created_on']));
				
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
	}
	
	function verifyOrderNo($orderNo){
		global $conn;
		$query = mysqli_query($conn,"SELECT id FROM order_tb WHERE order_no = '$orderNo'");
		if(mysqli_num_rows($query) === 1){
			return true;
		}else{
			return false;
		}
	}
	//creates a new payment record and returns payment ID
	function createPaymentRecord($amount,$mode,$paid_by,$transaction){
		global $conn;
		$query = mysqli_query($conn,"INSERT INTO payment_tb(payment_id,transaction_no,amount,payment_mode,paid_by)
		VALUES(null,'$transaction','$amount','$mode','$paid_by')");
		if($query){
			$id = mysqli_insert_id($conn);
		}else{
			$id = 0;
		}
		return $id;
	}
	function updateOrderPayment($orderNo,$paymentId){
		global $conn;
		$query = mysqli_query($conn,"UPDATE order_tb SET payment_id = '$paymentId' WHERE order_no = '$orderNo'");
		if($query){
			return true;
		}
		else{
			return false;
		}
	}
?>