<?php
session_start();
include('includes/database.php');
//set items count
if(!isset($_SESSION['items']))
{
  $items=0;
  $_SESSION['items']=$items;
}





//get last inserted order_id
if (!isset($_SESSION['order_id'])){
$sql_last_order_id="SELECT MAX(order_id) AS order_id FROM orders";
$result_order_id = $conn->query($sql_last_order_id);
$row_order_id = $result_order_id->fetch_assoc();
$order_id=$row_order_id['order_id']+1;
$_SESSION['order_id']=$order_id;
//print_r($order_id);
}
else{
$order_id=$_SESSION['order_id'];
// $sql_get_order_details="SELECT * FROM orders, products WHERE orders.product_id=products.product_id AND orders.order_id=$order_id";
// $query_get_orders=$conn->query($sql_get_order_details);
// $result_get_orders=$query_get_orders->fetch_assoc();
// $row_orders_qty=$result_get_orders['qty'];

if($_SESSION['items']!=0){
  $show_items_count=$_SESSION['items']-1;
  //$show_qty.=$row_orders_qty
}
}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Supermarket</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body background="https://wallpaperaccess.com/full/1624845.jpg"   >
<center>

<table background="https://media.istockphoto.com/vectors/green-and-blue-abstract-bokeh-background-vector-id184367909?k=20&m=184367909&s=612x612&w=0&h=XC_oleaYGYGuH5uD6d2M_RtF39Q39GNf05p8x1fn4Ik=" width="1000" border="2">
  <tr>
    <td height="300" colspan="6"><img src="https://img.freepik.com/free-vector/flat-supermarket-twitch-banner_23-2149357203.jpg?w=2000"  width="1200" height="300"/></td>
  </tr>
  <tr>
    <td height="50" colspan="6"><p align="center" class="style6">Invoice</p>
      <form id="form1" name="form1" method="post" action="get_customer_details.php">
				<table class="main">
					<tr>
						<td><label><span class="style7">Customer Name</span>
		        <select name="slt_customer">
              <?php
              if(isset($_GET['customer_name'])){

                echo '<option value="'.$_GET['customer_id'].'" selected>'.$_GET['customer_name']. '</option>';
              }
              else{
              $sql_get_customer="SELECT * FROM customer";
              $result_customer = $conn->query($sql_get_customer);
              while($row_cust=$result_customer->fetch_assoc()){
                echo '<option value="'.$row_cust['customer_id'].'">'.$row_cust['customer_name']. '</option>';
              }
            }?>
            </select><button type="submit" name="btn_submit">Select</button></label></td>

						<td><label><span class="style7">Mobile Number</span>
		        <input type="text" name="textfield" placeholder="<?php if(isset($_GET['customer_mobile'])) echo $_GET['customer_mobile']; ?>" />
		        </label></td>
						<td><label> <span class="style7">Invoice  Number</span>
							<input type="text" name="textfield2"  placeholder="<?php if(isset($order_id)) echo $order_id; ?>"/></label></td>
					</tr>
						<tr>
							<td><label><span class="style7">Customer Address</span>
			        <input type="text" name="textfield3"  placeholder="<?php if(isset($_GET['customer_address'])) echo $_GET['customer_address']; ?>"/>
			          </label>
							</td>
							<td><label><span class="style7">Brn Number </span>
			        <input type="text" name="textfield4"  placeholder="<?php if(isset($_GET['customer_brn'])) echo $_GET['customer_brn']; ?>"/>
			        </label>
							</td>
							<td><label><span class="style7">Date</span>
			        <input type="text" name="txtDate" placeholder="<?php echo date('d/m/Y'); ?>"/>
			        </label>
						</td>
						</tr>
            </form>
            <tr>
              <td>
                <form name="frm_add_product" class="form" action="calculate_total.php" method="post">
                  <input type="text" name="customer_id" hidden value="<?php echo $_GET['customer_id']; ?>">
                  <!-- <button type="submit" name="btn_add_product">Add Product</button> -->
                  <a href="close_invoice.php">New Customer</a>
                </form>


              </td>
            </tr>
				</table>


  <tr bgcolor="#000000">
    <td width="100" height="100"><div align="center" class="style5">QTY</div></td>
    <td width="300" height="100"><div align="center" class="style5">Products </div></td>
    <td width="200" height="100"><div align="center" class="style5">Ref</div></td>
    <td width="200" height="100"><div align="center" class="style5">Barcode</div></td>
    <td width="200" height="100"><div align="center" class="style5">Price </div></td>
    <td width="200" height="100"><div align="center" class="style5">Total</div></td>

  </tr>
  <form name="frm_calculate_products" method="POST" action="<?php echo 'get_customer_details.php?customer_id='.$_GET['customer_id'].'&order_id='.$order_id; ?>">

    <?php
    if(isset($_GET['customer_id'])){
      echo '<input type="text" name="txt_customer_id"  placeholder="'.$_GET['customer_id'].'"/>';
    }

      $sql_get_products="SELECT * FROM products";
      $result_products = $conn->query($sql_get_products);
      $lst_products='';
      while($row_prod=$result_products->fetch_assoc()){
        //$lst_products='';
        $lst_products.= '<option value="'.$row_prod['product_id'].'">'.$row_prod['product_name']. '</option>';
      }
//show items by invoice
if($_SESSION['items']!=0){
   $sql_get_order_details="SELECT * FROM orders, products WHERE orders.product_id=products.product_id AND orders.order_id=$order_id ORDER BY invoice_id";
   $query_get_orders=$conn->query($sql_get_order_details);
   while($row_get_orders=$query_get_orders->fetch_assoc()){
     echo
     '<tr>
      <td>'.$row_get_orders['qty'].'</td>
      <td>'.$row_get_orders['product_name'].'</td>
      <td>'.$row_get_orders['product_ref'].'</td>
      <td>'.$row_get_orders['product_barcode'].'</td>
      <td>'.$row_get_orders['product_price'].'</td>
      <td>'.$row_get_orders['total_price'].'</td>
     </tr>';
   }
}

      //$i=10;
      for ($i=0;$i<1;$i++){
        echo '

        <tr>
          <td>
            <input type="text" name="txt_qty'.$i.'" value="">
          </td>
          <td>
          <select name="lst_product'.$i.'">
          '.$lst_products.'
          </select>
          <input type="text" name="product_row" value="'.$i.'" hidden>

          <button type="submit" name="btn_add_products"> Add Product </button>

          </td>

          <td>
          <input type="text" name="txt_ref'.$i.'">
          </td>
          <td>
          </td>
          <td>
          </td>
          <td>
          </td>
        </tr>
        ';
    }?>
    </form>


  <tr>
    <td height="50" colspan="4">&nbsp;</td>
    <td height="50" bgcolor="#00FF00"><div align="center" class="style8"><span class="style6">Net Total </span></div></td>
    <td height="50" >
      <?php
      //get total
      $sql_total="SELECT SUM(total_price) AS total_sum FROM orders WHERE order_id=$order_id";
      $query_total=$conn->query($sql_total);
      $row_total = $query_total->fetch_assoc();
       ?>
      <div align="center" style="font-color:black;font-weight: bold;font-size: 36px;"><?php echo $row_total['total_sum']; ?></div>
    </td>
  </tr>
</table>


</center>





</body>
</html>
