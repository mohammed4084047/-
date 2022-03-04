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

  if(isset($_GET['Restaurants_id'])) {
  $query3 = "SELECT * FROM restaurants WHERE Restaurant_id=".$_GET['Restaurants_id'];
  $result3 = mysqli_query($db, $query3);
  $row3 = mysqli_fetch_array($result3);
  
  $query2 = "SELECT * FROM products WHERE Restaurants_id=".$_GET['Restaurants_id'];
  $result2 = mysqli_query($db, $query2);
  } else {
    header("refresh:3;restr");
  }
  if (isset($_POST['add_menu']))
  {
      $Restaurants_id = $_GET['Restaurants_id'];
      $name = trim($_POST['name']);
      $nameEn = trim($_POST['nameEn']);
      $price = trim($_POST['price']);
   
      $imgFile = $_FILES['file']['name'];
      $tmp_dir = $_FILES['file']['tmp_name'];
      $imgSize = $_FILES['file']['size'];
      
          if (empty($name)){
              $error = true;
              $errMSG = "الرجاء كتابة اسم الوجبة";
          } else if (empty($nameEn)){
            $error = true;
            $errMSG = "الرجاء كتابة اسم الوجبة بالإنجليزي";
        } else if (empty($price)){
              $error = true;
              $errMSG = "الرجاء كتابة السعر";
          } 
          
              if($imgFile)
          {
              $upload_dir = '../menu/'; // upload directory	
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
          
    
      if (!$error) {
    $sql="INSERT INTO products(Restaurants_id,Product_Name,Product_Name_en,Product_pics,Price) VALUES('$Restaurants_id','$name','$nameEn','$userpic','$price')";
    $res7 = mysqli_query($db,$sql);
    
      if ($res7) {
        $errTyp = "success";
        $sucMSG = "تمت إضافة الوجبة بنجاح";
        header("refresh:3;menu.php?Restaurants_id=$Restaurants_id");
              } else {
                  $errTyp = "danger";
                  $errMSG = "حدث خطاء";	
              }
  
  
      }
  }

  if(isset($_GET['delete']) && isset($_GET['Restaurants_id']))
  {
    $delete = $_GET['delete'];
    $Restaurants_id = $_GET['Restaurants_id'];
  $query4 = "DELETE FROM products WHERE Product_id =".$delete;
  $results4 = mysqli_query($db, $query4);
  if ($results4) {
    ?>
  <script>
  alert('تم مسح الوجبة بنجاح');
    window.location.href='menu?Restaurants_id=<?php echo $Restaurants_id; ?>';
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
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="restr">المطاعم</a></li>
    <li class="breadcrumb-item active">قائمة مطعم <?php echo $row3['Restaurant_name']; ?></li>
  </ol>
</nav>

<div class="jumbotron py-2 px-3 mb-2 bg-dark text-white">
  <h3 class="p-0"><i class="fas fa-utensils"></i> قائمة مطعم <?php echo $row3['Restaurant_name']; ?> 
  <button type="button" class="btn btn-outline-light float-right mt-0" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>  وجبة جديدة </button>
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
<div class="col-md-3 mb-4">
    <div class="card">
      <img src="../menu/<?php echo $row2['Product_pics']; ?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title"><?php echo $row2['Product_Name']; ?> <small class="float-right"><?php echo $row2['Price']; ?> ريال</small></h5>
        <p class="card-text">
        <div class="btn-group btn-group-sm btn-block" role="group" aria-label="Basic example">
  <a type="button" href="editMenu?Product_id=<?php echo $row2['Product_id']; ?>&Restaurants_id=<?php echo $row2['Restaurants_id']; ?>" class="btn btn-warning"><i class="far fa-edit"></i> تعديل</a>
  <a type="button" href="?delete=<?php echo $row2['Product_id']; ?>&Restaurants_id=<?php echo $_GET['Restaurants_id']; ?>"  onclick="return confirm('هل تريد مسح الوجبة؟')" class="btn btn-danger"><i class="far fa-trash-alt"></i> مسح</a>
</div>
        </p>
      </div>
    </div>
  </div>

 <?php } ?> 
</div> <?php } else { ?>
  <div class="alert alert-danger alert-dismissible  bg-danger text-white fade show px-3" style="border:none; border-radius:0px;" role="alert">
  <i class="fas fa-exclamation-triangle"></i>&nbsp; <strong>لا توجد وجبات </strong> 
</div>
 <?php } ?>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">إضافة وجبة جديدة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="modal-body">
      
  <div class="form-group">
    <label for="exampleFormControlInput1">إسم الوجبة بالعربي</label>
    <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="إسم الوجبة بالعربي">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">إسم الوجبة بالإنجليزي</label>
    <input type="text" class="form-control" name="nameEn" id="exampleFormControlInput1" placeholder="إسم الوجبة بالإنجليزي">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">السعر</label>
    <input type="number" class="form-control" name="price" id="exampleFormControlInput1" placeholder="السعر">
  </div>
  
  <div class="form-group">
    <label for="exampleFormControlFile1">صورة الوجبة</label>
    <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
  </div>

      </div>
      <div class="modal-footer">
        <button type="submit" name="add_menu" class="btn btn-primary btn-block">حفظ الوجبة</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php require_once 'footer.php'; ?>