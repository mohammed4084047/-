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

  if(isset($_GET['Product_id']) && isset($_GET['Restaurants_id'])) {
    $query3 = "SELECT * FROM products WHERE Product_id=".$_GET['Product_id'];
    $result3 = mysqli_query($db, $query3);
    $row3 = mysqli_fetch_array($result3);
    
    } else {
      header("refresh:3;restr");
    }

  if (isset($_POST['update_restr']))
  {
      $Product_id = $_GET['Product_id'];
      $Restaurants_id = $_GET['Restaurants_id'];
      $name = trim($_POST['name']);
      $nameEn = trim($_POST['nameEn']);
      $price = trim($_POST['price']);
   
      $imgFile = $_FILES['file']['name'];
      $tmp_dir = $_FILES['file']['tmp_name'];
      $imgSize = $_FILES['file']['size'];
      
          if (empty($name)){
              $error = true;
              $errMSG = "الرجاء كتابة اسم المطعم";
          } else if (empty($nameEn)){
            $error = true;
            $errMSG = "الرجاء كتابة اسم المطعم بالإنجليزي";
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
			// if no image selected the old image remain as it is.
			$userpic = $_POST['photo'];  // old image from database
		}
          
      if (!$error) {
        $sql="UPDATE products SET Product_Name='$name',
        Product_Name_en='$nameEn',
        Product_pics='$userpic',			
        Price='$price'
        WHERE Product_id='$Product_id'";

$res7 = mysqli_query($db,$sql);
      if ($res7) {
        $errTyp = "success";
        $sucMSG = "تمت التعديل بنجاح";
        header("refresh:3;menu.php?Restaurants_id=$Restaurants_id");
              } else {
                  $errTyp = "danger";
                  $errMSG = "حدث خطاء";	
              }
  
  
      }
  }

	?>

<!DOCTYPE html>
<?php require_once 'header.php'; ?>

<div class="container" style="margin-top:90px;">

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="menu?Restaurants_id=<?php echo $_GET['Restaurants_id']; ?>">كل الوجبات</a></li>
    <li class="breadcrumb-item active">تعديل الوجبة</li>
  </ol>
</nav>

<div class="jumbotron py-2 px-3 mb-2 bg-dark text-white">
  <h3 class="p-0"><i class="fas fa-utensils"></i> تعديل <?php echo $row3['Product_Name']; ?> 
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

<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
      <div class="modal-body">
      
  <div class="form-group">
    <label for="exampleFormControlInput1">إسم الوجبة بالعربي</label>
    <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="<?php echo $row3['Product_Name']; ?>">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">إسم الوجبة بالإنجليزي</label>
    <input type="text" class="form-control" name="nameEn" id="exampleFormControlInput1" value="<?php echo $row3['Product_Name_en']; ?>">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">السعر</label>
    <input type="number" class="form-control" name="price" id="exampleFormControlInput1" value="<?php echo $row3['Price']; ?>">
  </div>

  <div class="form-group">
    <label for="exampleFormControlFile1">صورة الوجبة</label>
    <img src="../menu/<?php echo $row3['Product_pics']; ?>" style="height: 90px;">
    <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
    <input class="form-control" type="hidden" name="photo" value="<?php echo $row3['Product_pics']; ?>"/>
  </div>

      </div>
      <div class="modal-footer">
        <button type="submit" name="update_restr" class="btn btn-primary btn-block">تعديل الوجبة</button>
      </div>
      </form>

</div>


<?php require_once 'footer.php'; ?>