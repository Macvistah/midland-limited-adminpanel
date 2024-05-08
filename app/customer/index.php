<?php
require_once "../database/conn.php";
	
	$action = $_POST['action'];
//	$action = $_GET['action'];
	//$action = 'order_count';
	
	switch ($action) {
		//cart options
		case 'add_to_cart':
			$userId = e($_POST['user_id']);
			$prodId = e($_POST['prod_id']);
			$qty    = e($_POST['qty']);
			$specs  = e($_POST['specs']);
			
			$query = mysqli_query($conn,"INSERT INTO cart_tb (id,user_id,prod_id,prod_qty,specifications)
			VALUES(null,'$userId','$prodId','$qty','$specs')");
			if($query){
				$result['success'] = "1";
				$result['message'] = "success";
			}
			else{
				$result['success'] = "0";
				$result['message'] = "Failed";
			}
			echo json_encode($result);
			mysqli_close($conn);
		break;
		case 'update_cart':
			$userId = e($_POST['user_id']);
			$prodId = e($_POST['prod_id']);
			$qty    = e($_POST['qty']);
			$specs  = e($_POST['specs']);
			
			$query = mysqli_query($conn,"UPDATE cart_tb SET prod_qty ='$qty' ,specifications = '$specs' WHERE
			user_id  = '$userId' AND prod_id ='$prodId'");
			if($query){
				$result['success'] = "1";
				$result['message'] = "success";
			}
			else{
				$result['success'] = "0";
				$result['message'] = "Failed";
			}
			echo json_encode($result);
			mysqli_close($conn);
		break;
		case 'read_cart':
			$userId = e($_POST['user_id']);
			$query  = mysqli_query($conn,"SELECT c.id,c.prod_id,ct.name,p.prod_name,p.discount,c.prod_qty, p.price,c.specifications,p.description,p.qty,p.image FROM product_tb p, cart_tb c, category_tb ct WHERE p.prod_id=c.prod_id AND c.user_id = '$userId' AND ct.id = p.category_id");
			
			$result = array();
			$result['read'] = array();
	
			if (mysqli_num_rows($query)>0)
				{
					while ($row = mysqli_fetch_assoc($query)) {
			 
						 $h['cart_id']       			  = $row['id'] ;
						 $h['prod_id']       			  = $row['prod_id'];
						 $h['prod_image']       		  = $product_url.$row['image'];
						 $h['prod_name']       	  		  = $row['prod_name'];
						 $h['prod_category']       	  	  = $row['name'];
						 $h['prod_qty']       	 		  = $row['qty'] ;
						 $h['prod_discount']       	 	  = $row['discount'] ;
						 $h['cart_qty']       	  	  	  = $row['prod_qty'] ;
						 $h['prod_price']       	  	  = $row['price'] ;
						 $h['prod_specs']       	  	  = $row['specifications'] ;
						 $h['prod_desc']       	  	  	  = $row['description'] ;
			  
						 
						 array_push($result["read"], $h);
					}
					$result["success"] = "1";
					echo json_encode($result);
				}

			 else {
			 
				 $result["success"] = "0";
				 $result["message"] = "Error!";
				 echo json_encode($result);
			
			 }	
			 mysqli_close($conn);
		break;
		case'remove_from_cart':
			$id = e($_POST['id']);
			$query = mysqli_query($conn,"DELETE FROM cart_tb WHERE id = '$id'");
			if($query){
				$result['success'] = "1";
				$result['message'] = "success";
			}else{
				$result['success'] = "0";
				$result['message'] = "Failed";
			}
			echo json_encode($result);
			mysqli_close($conn);
			
		break;
		case 'clear_cart':
			$id = e($_POST['user_id']);
			$query = mysqli_query($conn,"DELETE FROM cart_tb WHERE user_id = '$id'");
			if($query){
				$result['success'] = "1";
				$result['message'] = "success";
			}else{
				$result['success'] = "0";
				$result['message'] = "Failed";
			}
			echo json_encode($result);
			mysqli_close($conn);
		break;
		case 'get_cart_count':
			//calls a function to get the cart count
			$id    = e($_POST['user_id']);
			$count = getCartCount($id);
				$result['count']   = $count;
				$result['success'] = "1";
				$result['message'] = "success";
				echo json_encode($result);
				mysqli_close($conn);
		break;
		case 'verify_product_cart':
			//calls a function to get if product is in the cart and returns quantity
			$userId = e($_POST['user_id']);
			$prodId = e($_POST['prod_id']);
			$qty = verify_product_cart($userId,$prodId);
				if($qty >0){
					$result['success'] = "1";
					$result['qty'] 	   = $qty ;
					$result['message'] = "success";
					echo json_encode($result);
				}
				else{
					$result['success']  = "0";
					$result['message'] = "absent";
					echo json_encode($result);	
				}
				mysqli_close($conn);
		break;
		
		//order options
		case 'place_order':
		 $order_no    = strtoupper(substr("MLO", 0, 4)).date("ym").rand(pow(10,3), pow(10,2));
		 $userId      = e($_POST['id']);
		 $total       = e($_POST['total']);
		 $transaction_no = e($_POST['transaction_code']);
		 $status = 'Pending';
		 
		 //order details
		 $cart_list = $_POST['jsonArray'];
		 $array = json_decode($cart_list,true);
		 
		 //delivery details
		 $name = e($_POST['name']);
		 $phone = e($_POST['phone']);
		 $point = e($_POST['point']);
		 $charge = getPickUpPointCharge($point);
		 
		 //compute total amount = shipping charge + product total amount
		 $total  +=$charge ;
		 $query  = mysqli_query($conn,"INSERT INTO order_tb (id,order_no,user_id,payment_id,shipping_charge,total_amount,status)
		 VALUES(null,'$order_no','$userId','$transaction_no','$charge','$total','$status')");
		 if($query){
			 $orderId = mysqli_insert_id($conn);
			 if(saveOrderDetails($orderId,$array)&&saveDeliveryDetails($orderId,$name,$phone,$point)){
				 $result ["order_id"] = mysqli_insert_id($conn);
				 $result ["total"] = $total;
			     $result["success"] = "1";
				 $result["message"] = "success";
				 echo json_encode($result);
			 }
			 else{
				 $result["success"] = "0";
				 $result["message"] = "Failed";
				 echo json_encode($result);
			 }
		 }
		 else{
			 $result["success"] = "2";
			 $result["message"] = "Failed!";
			 echo json_encode($result);
		 }
		 
		 mysqli_close($conn);
	
		break;
		case 'view_order':
			$userId = e($_POST['user_id']);
			//$status  = e($_POST['status']);
			$result = array();
			$result['read'] = array();
			$query  = mysqli_query($conn,"SELECT o.id, o.payment_id,o.order_no,o.shipping_charge,o.total_amount,o.order_date,o.status,s.location FROM order_tb o,shipping_details s WHERE o.user_id = '$userId' AND s.order_id = o.id ORDER BY o.id DESC");
			if(mysqli_num_rows($query)>0){
				while($row = mysqli_fetch_assoc($query)){
					
					$h['id'] 			  	 = $row['id'];
					$h['order_no'] 	 	 	 = $row['order_no'];
					$h['charge'] 			 = $row['shipping_charge'];
					$h['total_amount'] 	     = $row['total_amount'];
					$h['date']	 	 	     = date('M d, Y ',strtotime($row['order_date']));
					$h['status'] 	     	 = $row['status'];
					$h['location']			 = $row['location'];
					
					if($row['payment_id']!= null){
						$h['payment']		 = $row['payment_id'];
					}
					else{
						$h['payment']		 = 'Not Paid';
					}
					
					array_push($result["read"], $h);	
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
		case 'view_order_details':
			$orderId  = e($_POST['order_id']);
			$result = array();
			$result['read'] = array();
			$query  = mysqli_query($conn,"SELECT o.id,p.prod_name,o.qty,o.price,o.specifications FROM order_details o, product_tb p WHERE o.order_id = '$orderId' AND p.prod_id = o.prod_id");
			if(mysqli_num_rows($query)>0){
				while($row = mysqli_fetch_assoc($query)){
					
					$h['id'] 			  	 	 = $row['id'];
					$h['prod_name'] 			 = $row['prod_name'];
					$h['qty'] 			  	 	 = $row['qty'];
					$h['price'] 			  	 = $row['price'];
					$h['specs'] 			  	 = $row['specifications'];
					
					array_push($result["read"], $h);	
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
		case 'order_count':
		$userId = e($_POST['user_id']);	
		$result["Pending"]    =getOrderCount($userId,"Pending");
		$result["Approved"]   =getOrderCount($userId,"Approved");
		$result["Dispatched"] =getOrderCount($userId,"Dispatched");
		$result["Delivered"]  =getOrderCount($userId,"Delivered");
		$result["Completed"]  =getOrderCount($userId,"Completed");
		$result["Cancelled"]  =getOrderCount($userId,"Cancelled");
		$result["Count"] 	  =getOrderCount($userId,null);
		$result["success"] = "1";
		echo json_encode($result);
		break;
		
		case 'update_order_status':
			$orderId = isset($_POST['order_id']) ? e($_POST['order_id']) : null;
			$status  = isset($_POST['status']) ? e($_POST['status']) : null;

            if (!$orderId || !$status){
                $result["success"] = "0";
                $result["message"] = "Order ID or status missing!";
                echo json_encode($result);
                mysqli_close($conn);
                return;
            }


			$query  = mysqli_query($conn,"UPDATE order_tb SET status = '$status' WHERE id ='$orderId'");
			if($query){

                if($status == 'Approved'){
                    decrementStock($conn, $orderId);
                    return;
                }

				//success
				if($status=='Delivered'){
					updateDeliveryTime($orderId);
				}

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
	function saveOrderDetails($orderId,$array){
		global $conn;
		foreach($array as $item){
		 $query = mysqli_query($conn,"INSERT INTO order_details (id ,order_id ,prod_id ,qty ,price,specifications)
		 VALUES(null,'$orderId','".$item['prod_id']."','".$item['prod_qty']."','".$item['prod_price']."','".$item['prod_specs']."')");
		}
		if ($query){
				return true;
			}
			else {
				return false;
			}
		
	}
	
	function updateDeliveryTime($orderId){
		global $conn;
		$date = date("Y-m-d H:i:s");
		$query = mysqli_query($conn,"UPDATE shipping_details SET delivery_date ='$date'");
		if ($query){
			//return true;
		}
		else {
			//return false;
		}
	}
	
	function saveDeliveryDetails($orderId,$name,$phone,$point){
		global $conn;
		$query = mysqli_query($conn,"INSERT INTO shipping_details (id,order_id,full_name,phone_no,location)
		VALUES(null,'$orderId','$name','$phone','$point')");
		if ($query){
			return true;
		}
		else {
			return false;
		}
	}
	
	function verify_product_cart($userId,$productId){
		global $conn;
		$query = mysqli_query($conn,"SELECT prod_qty FROM cart_tb WHERE user_id = '$userId' AND prod_id = '$productId' LIMIT 1");
		if(mysqli_num_rows($query) ===1){
			$row = mysqli_fetch_assoc($query);
			$qty = $row['prod_qty'];
			return $qty;
		}else{
			return 0;
		}
	}
	function getCartCount($userId){
		global $conn;
		$query = mysqli_query($conn, "SELECT count(*) FROM cart_tb WHERE user_id = '$userId'");
		if($query){
			$row = mysqli_fetch_assoc($query);
			return $row['count(*)'];
		}
		else{
			return 0;
		}
		
	}
	function getOrderCount($userId,$status){
		global $conn;
		if(!empty($status)){
			$query = mysqli_query($conn, "SELECT count(*) FROM order_tb WHERE user_id = '$userId' AND status ='$status' ");
		}
		else{
			$query = mysqli_query($conn, "SELECT count(*) FROM order_tb WHERE user_id = '$userId'");
		}
		if($query){
			$row = mysqli_fetch_assoc($query);
			return $row['count(*)'];
		}
		else{
			return 0;
		}
		
	}

	function getPickUpPointCharge($name){
		global $conn;
		$query = mysqli_query($conn,"SELECT charge FROM pick_up_points WHERE p_name ='$name'");
		if(mysqli_num_rows($query)>0){
			while ($row = mysqli_fetch_assoc($query)) {
				 $charge  = $row['charge'] ;
			}
			return $charge;
		}
		else
			return 0;
	}
    
    function decrementStock($conn, $orderId){
        $query = mysqli_query($conn, "
            UPDATE product_tb AS p
            JOIN order_details AS od ON p.prod_id = od.prod_id
            SET p.qty = p.qty - od.qty
            WHERE od.order_id = '$orderId';
        ");
        
        if ($query){
            $result["success"] = "1";
            $result["message"] = "Decremented Stock successfully!";
            echo json_encode($result);
        }
        else{
            $result["success"] = "0";
            $result["message"] = "An error occurred!";
            echo json_encode($result);
        }
    }
    
?>