<?php
include('includes/database.php');
$customer_id=$_POST['slt_customer'];
$sql_get_customer_details="SELECT * FROM customer WHERE customer_id=$customer_id";
$result_customer = $conn->query($sql_get_customer_details);
$row_cust=$result_customer->fetch_assoc();
$customer_id=$row_cust['customer_id'];
$customer_name=$row_cust['customer_name'];
$customer_mobile=$row_cust['customer_mobile'];
$customer_address=$row_cust['customer_address'];
$customer_brn=$row_cust['customer_brn'];

 if(isset($_POST['product_id'])){

   $sql_add_product = "INSERT INTO orders";

 }


header("location:index.php?customer_id=".$customer_id."&customer_name=".$customer_name."&customer_mobile=".$customer_mobile."&customer_address=".$customer_address.
"&customer_brn=".$customer_brn);







 ?>
