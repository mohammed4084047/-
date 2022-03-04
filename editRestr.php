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
    
    } else {
      header("refresh:3;restr");
    }

  if (isset($_POST['update_restr']))
  {
      $Restaurants_id = $_GET['Restaurants_id'];
      $name = trim($_POST['name']);
      $nameEn = trim($_POST['nameEn']);
      $section = trim($_POST['section']);
   
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
			// if no image selected the old image remain as it is.
			$userpic = $_POST['photo'];  // old image from database
		}
          
      if (!$error) {
        $sql="UPDATE restaurants SET Restaurant_name='$name',
        Restaurant_name_en='$nameEn',
        Section='$section',			
        Restaurant_logo='$userpic'
        WHERE Restaurant_id='$Restaurants_id'";

$res7 = mysqli_query($db,$sql);
      if ($res7) {
        $errTyp = "success";
        $sucMSG = "تمت التعديل بنجاح";
        header("refresh:3;restr");
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
    <li class="breadcrumb-item"><a href="restr">المطاعم</a></li>
    <li class="breadcrumb-item active">تعديل المطعم</li>
  </ol>
</nav>

<div class="jumbotron py-2 px-3 mb-2 bg-dark text-white">
  <h3 class="p-0"><i class="fas fa-utensils"></i> تعديل مطعم <?php echo $row3['Restaurant_name']; ?> 
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
    <label for="exampleFormControlInput1">إسم المطعم بالعربي</label>
    <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="<?php echo $row3['Restaurant_name']; ?>">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">إسم المطعم بالإنجليزي</label>
    <input type="text" class="form-control" name="nameEn" id="exampleFormControlInput1" value="<?php echo $row3['Restaurant_name_en']; ?>">
  </div>

  <div class="form-group">
    <label for="exampleFormControlSelect1">قسم المطعم</label>
    <select class="form-control" name="section" id="exampleFormControlSelect1">
    <option selected value="<?php echo $row3['Section']; ?>"><?php 
      $query25 = "SELECT * FROM section WHERE sID=".$row3['Section'];
	  $result25 = mysqli_query($db, $query25); 
      $row25 = mysqli_fetch_array($result25);
      echo $row25['sectionAr']; ?></option>
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
    <img src="../logo/<?php echo $row3['Restaurant_logo']; ?>" style="height: 90px;">
    <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
    <input class="form-control" type="hidden" name="photo" value="<?php echo $row3['Restaurant_logo']; ?>"/>
  </div>

      </div>
      <div class="modal-footer">
        <button type="submit" name="update_restr" class="btn btn-primary btn-block">تعديل المطعم</button>
      </div>
      </form>

</div>


<?php require_once 'footer.php'; ?>