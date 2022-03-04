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

  if (isset($_POST['add_restr']))
  {
      
      $name = trim($_POST['name']);
      $nameEn = trim($_POST['nameEn']);
      $section = trim($_POST['section']);
      $phone = trim($_POST['phone']);
      $pass = trim($_POST['pass']);
   
      $imgFile = $_FILES['file']['name'];
      $tmp_dir = $_FILES['file']['tmp_name'];
      $imgSize = $_FILES['file']['size'];
      
          if (empty($name)){
              $error = true;
              $errMSG = "الرجاء كتابة اسم المطعم";
          } else if (empty($nameEn)){
            $error = true;
            $errMSG = "الرجاء كتابة اسم المطعم بالإنجليزي";
          } else if (empty($section)){
              $error = true;
              $errMSG = "الرجاء إختيار قسم المطعم";
          } else if (empty($phone)){
            $error = true;
            $errMSG = "كتابة رقم جوال المطعم";
          } else if (empty($pass)){
            $error = true;
            $errMSG = "كتابة كلمة المرور";
          } else {
            // check email exist or not
            $query21 = "SELECT phone FROM restaurants WHERE phone='$phone'";
            $result21 = mysqli_query($db, $query21);
            $count = mysqli_num_rows($result21);
            if($count!=0){
                $error = true;
                $errMSG = "هذا الرقم مستخدم مسبقا";
            }
        }
        
          
              if($imgFile)
          {
              $upload_dir = '../logo/'; // upload directory	
              $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
              $valid_extensions = array('jpeg', 'jpg', 'png', 'gif' ,'webp'); // valid extensions
              $userpic = rand(1000,1000000).".".$imgExt;
              if(in_array($imgExt, $valid_extensions))
              {			
                  if($imgSize < 5000000)
                  {
                      move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                  }
                  else
                  {
                      $error = true;
                      $errMSG = "Sorry, your file is too large it should be less then 5MB";
                  }
              }
              else
              {
                  $error = true;
                  $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
              }	
          }
          else
          {
              $error = true;
                  $errMSG = "الرجاء إختيار صورة للمنتج";
          }
          
          $password = md5($pass);
      if (!$error) {
    $sql="INSERT INTO restaurants(Restaurant_name,Restaurant_name_en,Section,Restaurant_logo,phone,password) VALUES('$name','$nameEn','$section','$userpic','$phone','$password')";
    $res7 = mysqli_query($db,$sql);
    
      if ($res7) {
        $errTyp = "success";
        $sucMSG = "تمت إضافة المطعم بنجاح";
        header("refresh:3;restr");
              } else {
                  $errTyp = "danger";
                  $errMSG = "حدث خطاء";	
              }
  
  
      }
  }

  $query2 = "SELECT * FROM restaurants";
	$result2 = mysqli_query($db, $query2);

  
  if(isset($_GET['delete']))
  {
  $query4 = "DELETE FROM restaurants WHERE Restaurant_id =".$_GET['delete'];
  $results4 = mysqli_query($db, $query4);
  $query5 = "DELETE FROM products WHERE Restaurants_id =".$_GET['delete'];
  $results5 = mysqli_query($db, $query5);
  if ($results4) {
    ?>
  <script>
  alert('تم مسح المطعم بنجاح');
    window.location.href='restr';
    </script>
    <?php
  } else {
    $errTyp = "danger";
    $errMSG = "حدث خطاء";	
  }
  }

	?>

<!DOCTYPE html>
<?php require_once 'header.php'; ?>

<div class="container" style="margin-top:90px;">
<div class="jumbotron py-2 px-3 mb-2 bg-dark text-white">
  <h3 class="p-0"><i class="fas fa-utensils"></i> المطاعم 
  <button type="button" class="btn btn-outline-light float-right mt-0" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> مطعم جديد</button>
</h3>
</div>

<?php
 if(isset($errMSG) && $errMSG != ""){
			?>
<div class="alert alert-danger alert-dismissible  bg-danger text-white fade show px-3" style="border:none; border-radius:0px;" role="alert">
  <i class="fas fa-exclamation-triangle"></i>&nbsp; <strong><?php echo $errMSG; ?></strong> 
</div>
<?php
	} else if(isset($sucMSG) && $sucMSG != ""){ ?>
	<div class="alert alert-success alert-dismissible  bg-success text-white fade show px-3" style="border:none; border-radius:0px;" role="alert">
  <i class="far fa-check-square"></i>&nbsp; <strong><?php echo $sucMSG; ?></strong> 
</div>
<?php } ?>

<?php if (mysqli_num_rows($result2) > 0) { ?>
<div class="row">
  <?php

  while($row2 = mysqli_fetch_array($result2)) {
  ?>

<div class="col-md-3 col-sm-6 mb-3">
<div class="card p-2">

<a href="?delete=<?php echo $row2['Restaurant_id']; ?>" class="card-link float-right text-danger" onclick="return confirm('هل تريد مسح المطعم؟')"><i class="far fa-trash-alt"></i></a>
<center>
  <img src="../logo/<?php echo $row2['Restaurant_logo']; ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo $row2['Restaurant_name']; ?></h5>
   <!-- <p class="card-text">Some quick example.</p> -->
    <div class="btn-group" role="group" aria-label="Basic example">
  <a type="button" href="menu?Restaurants_id=<?php echo $row2['Restaurant_id']; ?>" class="btn btn-outline-info btn-sm">القائمة</a>
  <a type="button" href="editRestr?Restaurants_id=<?php echo $row2['Restaurant_id']; ?>" class="btn btn-outline-warning btn-sm">تعديل</a>
</div>
  </div>
  </center>
</div> 
        </div>

 <?php } ?> 
</div> <?php } else { ?>
  <div class="alert alert-danger alert-dismissible  bg-danger text-white fade show px-3" style="border:none; border-radius:0px;" role="alert">
  <i class="fas fa-exclamation-triangle"></i>&nbsp; <strong>لا توجد مطاعم </strong> 
</div>
 <?php } ?>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">إضافة مطعم جديد</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="modal-body">
      
  <div class="form-group">
    <label for="exampleFormControlInput1">إسم المطعم بالعربي</label>
    <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="إسم المطعم بالعربي">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">إسم المطعم بالإنجليزي</label>
    <input type="text" class="form-control" name="nameEn" id="exampleFormControlInput1" placeholder="إسم المطعم بالإنجليزي">
  </div>

  <div class="form-group">
    <label for="exampleFormControlSelect1">قسم المطعم</label>
    <select class="form-control" name="section" id="exampleFormControlSelect1">
    <?php 
    $query23 = "SELECT * FROM section";
	  $result23 = mysqli_query($db, $query23); 
    while($row23 = mysqli_fetch_array($result23)) {?>
      <option value="<?php echo $row23['sID']; ?>"><?php echo $row23['sectionAr']; ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlFile1">شعار المطعم</label>
    <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">رقم جوال المطعم</label>
    <input type="number" class="form-control" name="phone" id="exampleFormControlInput1" placeholder="05XXXXXXXX">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">كلمة المرور</label>
    <input type="password" class="form-control" name="pass" id="exampleFormControlInput1" placeholder="كلمة المرور">
  </div>

      </div>
      <div class="modal-footer">
        <button type="submit" name="add_restr" class="btn btn-primary btn-block">حفظ المطعم</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php require_once 'footer.php'; ?>