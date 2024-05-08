<?php
require_once "../database/conn.php";
	$action = $_POST['action'];
	switch ($action) {
	//used to manage product stock
		case 'create_product':
		$name 	 = e($_POST['name']);
		$cat 	 = e($_POST['category']);
		$qty     = e($_POST['qty']);
		$price   = e($_POST['price']);
		//$discount = e($_POST['discount']);
		$desc    = e($_POST['desc']);
		$image	 = $_POST['image'];
		$catId = getCategoryId($cat);
		
		$target_dir ="../../uploads/product_images/";
		$image_store = rand()."_".time().".jpeg";
		$path = $target_dir.$image_store;
		
		
		if(verifyProductName($name)){
			$result["success"] = "0";
			$result["message"] = "Product Name Exists";
			echo json_encode($result);
			mysqli_close($conn); 
		}
		else{
			if($catId>0){
				$query = mysqli_query($conn,"INSERT INTO product_tb(prod_id,prod_name,category_id,qty,price,description,image) 
											VALUES(null,'$name','$catId','$qty','$price','$desc','$image_store')");
				if($query){
					file_put_contents( $path, base64_decode($image));
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
					$result["success"] = "2";
					$result["message"] = "Failed";
					echo json_encode($result);
					mysqli_close($conn);
				}
		}
	break;
	    case 'view_discounted_products':
		$discount = 0;
		$query = mysqli_query($conn,"SELECT * FROM product_tb p ,category_tb c WHERE p.category_id = c.id AND p.discount>'$discount' ORDER BY id DESC");

		$result = array();
		$result['read'] = array();
	
		if (mysqli_num_rows($query)>0)
		{
			while ($row = mysqli_fetch_assoc($query)) {
	 
				 $h['id']       		  = $row['prod_id'] ;
				 $h['name']       	  	  = $row['prod_name'] ;
				 $h['category']       	  	  = $row['name'] ;
				 $h['qty']       	  	  	  = $row['qty'] ;
				 $h['price']       	  	  	  = $row['price'];
				 $h['discount']       	  	  = $row['discount'];
				 $h['desc']       	  	  = $row['description'] ;
				 $h['image']       		  = $product_url.$row['image'] ;
				 
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
		case 'view_products':
		$query = mysqli_query($conn,"SELECT * FROM product_tb p ,category_tb c WHERE p.category_id = c.id AND p.discount='0' ORDER BY id DESC");

		$result = array();
		$result['read'] = array();
	
		if (mysqli_num_rows($query)>0)
		{
			while ($row = mysqli_fetch_assoc($query)) {
	 
				 $h['id']       		  = $row['prod_id'] ;
				 $h['name']       	  	  = $row['prod_name'] ;
				 $h['category']       	  	  = $row['name'] ;
				 $h['qty']       	  	  	  = $row['qty'] ;
				 $h['price']       	  	  	  = $row['price'];
				 $h['discount']       	  	  = $row['discount'];
				 $h['desc']       	  	  = $row['description'] ;
				 $h['image']       		  = $product_url.$row['image'] ;
				 
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
	    case 'update_product':
		$id  	 = e($_POST['id']);
		$name 	 = e($_POST['name']);
		$cat 	 = e($_POST['category']);
		$qty     = e($_POST['qty']);
		$price   = e($_POST['price']);
		//$discount = e($_POST['discount']);
		$desc    = e($_POST['desc']);
		$catId = getCategoryId($cat);
			
		if($catId>0){
				$query = mysqli_query($conn,"UPDATE product_tb SET prod_name = '$name' , category_id = '$catId',qty = '$qty',price = '$price',description = '$desc' 
											WHERE prod_id = '$id'");
				if($query){
					$result["success"] = "1";
					$result["message"] = "success";
					echo json_encode($result);
					mysqli_close($conn);
				}
				else{
					$result["success"] = "0";
					$result["message"] = "Failed";
					echo json_encode($result);
					mysqli_close($conn);
				}
			}
			else{
					$result["success"] = "2";
					$result["message"] = "Failed";
					echo json_encode($result);
					mysqli_close($conn);
			}
		
	break;
	    case 'upload_image':
		$id 	 = e($_POST['id']);
		$image	 = $_POST['image'];
		
		$target_dir ="../uploads/product_images/";
		$image_store = rand()."_".time().".jpeg";
		$path = $target_dir.$image_store;
		
		$query = mysqli_query($conn,"UPDATE product_tb SET image = '$image_store' WHERE prod_id = '$id'");
		if($query){
			file_put_contents( $path, base64_decode($image));
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
	
	//used to manage the product categories
	    case 'create_category':
		$name 	= e($_POST['name']);
		if(verifyProductCatName($name)){
			$result["success"] = "0";
			$result["message"] = "Category Exists";
			echo json_encode($result);
			mysqli_close($conn); 
		}
		else{
			$query = mysqli_query($conn,"INSERT INTO category_tb(id,name) VALUES(null,'$name')");
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
	    case 'view_categories':
		$query = mysqli_query($conn,"SELECT * FROM category_tb");
		$result = array();
		$result['read'] = array();
		
		if (mysqli_num_rows($query)>0)
		{
			while ($row = mysqli_fetch_assoc($query)) {

				 $h['id']         		  = $row['id'] ;
				 $h['name']       		  = $row['name'] ;
			  
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
	    case 'edit_category':
		$id 	= $_POST['id'];
		$name 	= $_POST['name'];
		if(verifyProductCatName($name)){
			$result["success"] = "1";
			$result["message"] = "Error! Similar Category Name Available!";
			echo json_encode($result);
		}
		else{
			$query = mysqli_query($conn,"UPDATE category_tb SET name = '$name' WHERE id = '$id'");
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
		}
		 mysqli_close($conn);
	
	break;
	    case 'view_orders':
			$status  = e($_POST['status']);
			$driverId = e($_POST['driver_id']);
			$result = array();
			$result['read'] = array();
			if($driverId !=null ){
				$query  = mysqli_query($conn,"SELECT o.id, o.payment_id,o.order_no,o.shipping_charge,o.total_amount,o.order_date,o.status,s.location FROM order_tb o,shipping_details s WHERE  s.order_id = o.id AND s.driver_id = '$driverId' AND o.status = '$status'");
			}else{
				$query  = mysqli_query($conn,"SELECT o.id, o.payment_id,o.order_no,o.shipping_charge,o.total_amount,o.order_date,o.status,s.location FROM order_tb o,shipping_details s WHERE  s.order_id = o.id AND o.status = '$status'");
			}
			if(mysqli_num_rows($query)>0){
				while($row = mysqli_fetch_assoc($query)){
					
					$h['id'] 			  	 = $row['id'];
					$h['order_no'] 	 	 	 = $row['order_no'];
					$h['charge'] 			 = $row['shipping_charge'];
					$h['total_amount'] 	     = $row['total_amount'];
					$h['date']	 	 	     = date('d/m/Y',strtotime($row['order_date']));
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
		case 'decrement_stock':
				$cart_list = $_POST['jsonArray'];
				$array = json_decode($cart_list,true);
				foreach($array as $item){
					$query = mysqli_query($conn,"UPDATE product_tb SET qty = qty-'".$item['prod_qty']."' WHERE prod_name = '".$item['prod_name']."'"); 	
						  if ($query) {
							$result["success"] = "1";
							//$result["message"] = "success";
						} else {
							$result["success"] = "0";
							//$result["message"] = "error";	
						}
				}
				echo json_encode($result);
				mysqli_close($conn);
		break;

	
	}
	
	
	//functions
	
	function verifyProductCatName($name){
		global $conn;
		$query = mysqli_query($conn,"SELECT id FROM category_tb WHERE name ='$name'");
		if(mysqli_num_rows($query)>0){
			return true;
		}
		else
			return false;
	}
	function getCategoryId($name){
		global $conn;
		$query = mysqli_query($conn,"SELECT id FROM category_tb WHERE name ='$name'");
		if(mysqli_num_rows($query)>0){
			while ($row = mysqli_fetch_assoc($query)) {
				 $id  = $row['id'] ;
			}
			return $id;
		}
		else
			return 0;
	}
	function verifyProductName($name){
		global $conn;
		$query = mysqli_query($conn,"SELECT prod_id FROM product_tb WHERE prod_name ='$name'");
		if(mysqli_num_rows($query)>0){
			return true;
		}
		else
			return false;
	}
?>