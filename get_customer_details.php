<?php
session_start();
include('includes/database.php');



if(!isset($_SESSION['customer_id']))
{
$customer_id=$_POST['slt_customer'];
$_SESSION['customer_id']=$customer_id;
}
$customer_id=$_SESSION['customer_id'];
//$customer_id=$_POST['slt_customer'];

$sql_get_customer_details="SELECT * FROM customer WHERE customer_id=$customer_id";
$result_customer = $conn->query($sql_get_customer_details);
$row_cust=$result_customer->fetch_assoc();
$customer_id=$row_cust['customer_id'];
$customer_name=$row_cust['customer_name'];
$customer_mobile=$row_cust['customer_mobile'];
$customer_address=$row_cust['customer_address'];
$customer_brn=$row_cust['customer_brn'];
//save orders





 if(isset($_GET['order_id'])){
   //get items count
   $items=$_SESSION['items'];

   $order_id=$_GET['order_id'];
   $customer_id=$_GET['customer_id'];
   $product_id=$_POST['lst_product0'];
   $prod_qty=$_POST['txt_qty0'];

   $sql_get_product_details="SELECT * FROM products WHERE product_id=$product_id";
   $result_prod = $conn->query($sql_get_product_details);
   $row_prod = $result_prod->fetch_assoc();
   $prod_price=$row_prod['product_price'];
   $total_price=$prod_price*$prod_qty;
   //$order_id=$row_order_id['order_id']
   $_SESSION['items']=$items+1;
   $sql_insert="INSERT INTO orders(order_id,product_id,qty,total_price)VALUES('$order_id','$product_id','$prod_qty','$total_price')";
   $save_order = $conn->query($sql_insert);
 }

header("location:index.php?customer_id=".$customer_id."&customer_name=".$customer_name."&customer_mobile=".$customer_mobile."&customer_address=".$customer_address.
"&customer_brn=".$customer_brn);
 ?>
