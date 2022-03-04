<?php
ini_set( "display_errors", 0);
	ob_start();
	session_start();
	require_once 'dbconnect.php';
			if( isset($_SESSION['user']) ) {
		header("Location: home");
		exit;
  }
  $error = false;


		if( isset($_POST['login_btn']) ) {	
		
		$email = trim($_POST['email']);
		
		$pass = trim($_POST['pass']);
		

		if (empty($email)){
			$error = true;
			$errMSG = "الرجاء كتابة رقم الجوال";
		} else if (empty($pass)){
			$error = true;
			$errMSG = "الرجاء كتابة كلمة السر";
		}
		
		if (!$error) {
			
			$password = md5($pass);
		
			$query3 = "SELECT * FROM admin WHERE email='$email'";
			$result3 = mysqli_query($db, $query3);
			$count3 = mysqli_num_rows($result3); 
			$row3=mysqli_fetch_array($result3);
			if( $count3 == 1 && $row3['password']==$password) {
				$_SESSION['user'] = $row3['aID'];
				header("Location: home");
			} else {
				$errMSG = "رقم الجوال أو كلمة المرور خطاء الرجاء المحاولة مرة اخرى";
		} 
				
		}
		
	}
	
	?>
<!DOCTYPE html>
<html lang="en">
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
 <a class="navbar-brand pt-0 pb-1" href="index"><img src="../img/logo.png" style="height: 50px; "alt="avatar image"></a>

            </div>
      
</nav>
<div class="container" style="margin-top:90px;">


<div class="row">
<div class="col-md-3">

</div>
<div class="col-md-6">

<ul class="nav nav-tabs nav-justified md-tabs bg-warning" id="myTabMD" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" href="#"><i class="fas fa-sign-in-alt"></i> المدير </a>
  </li>
 
</ul>
<div class="tab-content card pt-1" id="myTabContentMD">
  <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
   <form action="index" method="post" enctype="multipart/form-data" class="text-center p-5">
  	<?php
 if(isset($errMSG) && $errMSG != ""){
			?>
<div class="alert alert-danger alert-dismissible  bg-danger text-white fade show px-3" style="border:none; border-radius:0px;" role="alert">
  <i class="fas fa-exclamation-triangle"></i>&nbsp; <strong><?php echo $errMSG; ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
	} else if(isset($sucMSG) && $sucMSG != ""){ ?>
	<div class="alert alert-success alert-dismissible  bg-success text-white fade show px-3" style="border:none; border-radius:0px;" role="alert">
  <i class="far fa-check-square"></i>&nbsp; <strong><?php echo $sucMSG; ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
    <p class="h4 mb-4">الدخول للمدير</p>
    <input type="email" name="email" class="form-control mb-4" placeholder="البريد الإلكتروني">
    <input type="password" name="pass" class="form-control mb-4" placeholder="كلمة المرور">


    <!-- Sign in button -->
    <button class="btn btn-warning btn-block my-4" type="submit" name="login_btn" ><i class="fas fa-sign-in-alt"></i> دخول</button>



</form>
  </div>

</div>
</div>
<div class="col-md-3">

</div>
</div>

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