<?php
include('includes/database.php');
$order_id=$_GET['order_id'];
$customer_id=$_GET['customer_id'];
$product_id=$_POST['lst_product0'];
$prod_qty=$_POST['txt_qty0'];

$sql_get_product_details="SELECT * FROM products";
$result_prod = $conn->query($sql_get_product_details);
$row_prod = $result_prod->fetch_assoc();
$prod_price=$row_prod['product_price'];
//$order_id=$row_order_id['order_id']

$sql_insert="INSERT INTO orders(order_id,product_id,qty,total_price)VALUES('$order_id','$product_id','$prod_qty',0)";
$save_order = $conn->query($sql_insert);

 ?>
