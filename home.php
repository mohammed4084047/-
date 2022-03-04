<?php 

ini_set( "display_errors", 0);
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	$error = false;
	if( isset($_SESSION['user']) ) {
	
	$query = "SELECT * FROM admin WHERE aID=".$_SESSION['user'];
	$result = mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);

  } else {
    header("Location: index");
  }
  
 
  $query2 = "SELECT * FROM orders";
	$result2 = mysqli_query($db, $query2);

	?>

<!DOCTYPE html>
<?php require_once 'header.php'; ?>
<div class="container" style="margin-top:90px;">
<div class="jumbotron py-2 px-3 mb-2 bg-dark text-white">
  <h3 class="p-0"><i class="fas fa-money-check-alt"></i> الطلبات</h3>
</div>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">إسم العميل</th>
      <th scope="col">رقم الجوال</th>
      <th scope="col">القيمة</th>
      <th scope="col">الحالة</th>
      <th scope="col">التاريخ</th>
      <th scope="col">عرض</th>
    </tr>
  </thead>
  <tbody>
  <?php
while($row2 = mysqli_fetch_array($result2))
		{ 
      $query3 = "SELECT * FROM customers WHERE Customer_id=".$row2['Customer_id'];
		  $result3 = mysqli_query($db, $query3);
			$row3 = mysqli_fetch_array($result3);
      ?>
    <tr>
      <th scope="row"><?php echo $row2['Order_id']; ?></th>
      <td><?php echo $row3['C_name']; ?></td>
      <td><?php echo $row3['Phone']; ?></td>
      <td><?php echo $row2['Order_Total']; ?></td>
      <td><?php if($row2['Status'] == 0){ echo"ملغي"; } 
      else if($row2['Status'] == 1){ echo"جديد"; } 
      else if($row2['Status'] == 2){ echo"تحت التجهيز"; }
      else if($row2['Status'] == 3){ echo"جاهز"; }
      else if($row2['Status'] == 4){ echo"توصيل"; } ?></td>
      <td><?php echo $row2['dat']; ?></td>
      <td>
      <a type="button" href="view.php?Order_id=<?php echo $row2['Order_id']; ?>" class="btn btn-primary btn-sm">عرض</a>  
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

</div>

<?php require_once 'footer.php'; ?>