
<?php
header("Content-Type:application/json");
if (!$request=file_get_contents('php://input')){
echo "Invalid input";
exit();
}

require_once "../database/conn.php";

if (!$conn) 
{
die("Connection failed: " . mysqli_connect_error());
}
		$request=file_get_contents('php://input');
        $array=json_decode($request,true);
        
        $resultCode=$array["Body"]["stkCallback"]["ResultCode"];
        $resultDesc=$array["Body"]["stkCallback"]["ResultDesc"];
        $merchantRequestID=$array["Body"]["stkCallback"]["MerchantRequestID"];
        $checkoutRequestID=$array["Body"]["stkCallback"]["CheckoutRequestID"];

        $transamount=$array["Body"]["stkCallback"]["CallbackMetadata"]["Item"][0]["Value"];
        $mpesaReceiptNumber=$array["Body"]["stkCallback"]["CallbackMetadata"]["Item"][1]["Value"];
        //$balance=$array["Body"]["stkCallback"]["CallbackMetadata"]["Item"][2]["Value"];;
        //$b2CUtilityAccountAvailableFunds=$array["Body"]["stkCallback"]["CallbackMetadata"]["Item"][3]["Value"];
        $transactionDate=$array["Body"]["stkCallback"]["CallbackMetadata"]["Item"][3]["Value"];
        $phoneNumber=$array["Body"]["stkCallback"]["CallbackMetadata"]["Item"][4]["Value"];
        
        if($resultCode==0)
		{
		$created_on = date("Y/m/d H:i:s");
		$order_id = $_GET["id"];
		
		$sql = mysqli_query($conn,"INSERT INTO payment_tb
    	( payment_id, transaction_no,amount,payment_mode,paid_by,created_on)
    	VALUES  (null,'$mpesaReceiptNumber','$transamount','Mpesa','$phoneNumber','$created_on')");
		
    	if (!$sql){
            //echo mysqli_error($conn); 
    	}
    	else{
    	  $id = mysqli_insert_id($conn);
		  $query = mysqli_query($conn,"UPDATE order_tb SET payment_id='$id' WHERE id='$order_id'");
			  if($query){
				  echo '{"ResultCode":0,"ResultDesc":"Confirmation received successfully"}';
			  }else{
				  echo 'We encountered an Error! ';
			  }
    	}
    	    
    	mysqli_close($conn);
		}
		else
		{
		    echo '{"ResultCode":1,"ResultDesc":"Transaction Not Successful"}';
		    mysqli_close($conn);
		}
         

?>
