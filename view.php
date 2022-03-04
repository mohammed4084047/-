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
  
  if(isset($_GET['Order_id'])) {
    $query2 = "SELECT * FROM orders WHERE Order_id =".$_GET['Order_id'];
    $result2 = mysqli_query($db, $query2);
    $row2 = mysqli_fetch_array($result2);
    $query5 = "SELECT * FROM customers WHERE Customer_id=".$row2['Customer_id'];
    $result5 = mysqli_query($db, $query5);
    $row5 = mysqli_fetch_array($result5);

    $query4 = "SELECT * FROM order_details WHERE Order_id=".$_GET['Order_id'];
	$result4 = mysqli_query($db, $query4);
	
    } else {
      header("Location: home");
    }

  

	?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title> المدير </title>
  <!-- Font Awesome -->
  <link rel="icon" href="../img/mdb-favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/bootstrap-rtl.css">
  <link rel="stylesheet" href="../css/mdb.min.css">

</head>

<body  style="font-family: 'Cairo', sans-serif;background:#fff;">
<nav class="navbar fixed-top navbar-expand-lg navbar-dark lighten-3 d-block p-0 mb-3 bg-warning">

  <div class="container py-2 px-3">
 <a class="navbar-brand pt-0 pb-1" href="index.php"><img src="../img/logo.png" style="height: 50px; "alt="avatar image"></a>
 <ul class="navbar-nav mr-auto nav-flex-icons">
	  <li class="nav-item active">
        <a class="nav-link" href="home"> الطلبات </a>

      </li>
      <li class="nav-item">
        <a class="nav-link" href="restr"> المطاعم </a>

      </li>
	  
      </ul>
<ul class="navbar-nav ml-auto nav-flex-icons">
	  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false"><i id="navbar-static-cart" class="fas fa-user"></i> مرحبا <?php echo $row['name']; ?></a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="logout?logout">خروج <i class="fas fa-sign-out-alt float-right mt-1"></i></a>
        </div>
      </li>
	  
      </ul>
            </div>
      
</nav>
<div class="container" style="margin-top:90px;">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="home.php">الطلبات</a></li>
    <li class="breadcrumb-item active"> تفاصيل الطلب</li>
  </ol>
</nav>
<div class="jumbotron py-2 px-3 mb-2 bg-dark text-white">
  <h3 class="p-0"><i class="fas fa-money-check-alt"></i> تفاصيل الطلب رقم <?php echo $row2['Order_id']; ?> </h3>
</div>
<h4>الإسم : <strong><?php echo $row5['C_name']; ?></strong></h4>
<h4>رقم الجوال : <strong><?php echo $row5['Phone']; ?></strong></h4>
<h4>العنوان : <strong><?php echo $row2['address']; ?></strong></h4>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">إسم الوجبة</th>
      <th scope="col">السعر</th>
      <th scope="col">الكمية</th>
      <th scope="col">المجموع</th>
    </tr>
  </thead>
  <tbody>
  <?php
while($row4 = mysqli_fetch_array($result4))
		{  ?>
    <tr>
      <th><?php echo $row4['Product_Name']; ?></th>
      <td><?php echo $row4['Price']; ?></td>
      <td><?php echo $row4['Quantity']; ?></td>
      <td><?php echo $row4['Total_Price']; ?></td>
    </tr>
    <?php } ?>
    <tr>  
                               <td colspan="3" align="right">المجموع الكلي</td>  
                               <td align="right"> <?php echo $row2['Order_Total']; ?> ريال
                              </td>  
                          </tr> 
  </tbody>
</table>

</div>


  <script src="../js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <script type="text/javascript" src="../js/mdb.min.js"></script>
  <script type="text/javascript" src="../js/jQuery.print.js"></script>
  <script type="text/javascript" src="../js/select2.min.js"></script>
  <script type="text/javascript" src="../js/addons/datatables.min.js"></script>

</body>
</html>
<?php ob_end_flush(); ?>