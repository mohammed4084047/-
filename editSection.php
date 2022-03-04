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

  if(isset($_GET['sID'])) {
    $query3 = "SELECT * FROM section WHERE sID=".$_GET['sID'];
    $result3 = mysqli_query($db, $query3);
    $row3 = mysqli_fetch_array($result3);
    
    } else {
      header("refresh:3;section");
    }

  if (isset($_POST['update_restr']))
  {
      $sID = $_GET['sID'];
      $sectionAr = trim($_POST['sectionAr']);
      $sectionEn = trim($_POST['sectionEn']);
      
          if (empty($sectionAr)){
              $error = true;
              $errMSG = "الرجاء كتابة اسم القسم بالعربي";
          } else if (empty($sectionEn)){
            $error = true;
            $errMSG = "الرجاء كتابة اسم القسم بالإنجليزي";
          }
        
          
          
      if (!$error) {
        $sql="UPDATE section SET sectionAr='$sectionAr',
        sectionEn='$sectionEn'
        WHERE sID='$sID'";

        $res7 = mysqli_query($db,$sql);
      if ($res7) {
        $errTyp = "success";
        $sucMSG = "تمت التعديل بنجاح";
        header("refresh:3;section");
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
    <li class="breadcrumb-item"><a href="section">الأقسام</a></li>
    <li class="breadcrumb-item active">تعديل القسم</li>
  </ol>
</nav>

<div class="jumbotron py-2 px-3 mb-2 bg-dark text-white">
  <h3 class="p-0"><i class="fas fa-utensils"></i> تعديل الأقسام <?php echo $row3['sectionAr']; ?> 
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
    <label for="exampleFormControlInput1">إسم القسم بالعربي</label>
    <input type="text" class="form-control" name="sectionAr" id="exampleFormControlInput1" value="<?php echo $row3['sectionAr']; ?>">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">إسم القسم بالإنجليزي</label>
    <input type="text" class="form-control" name="sectionEn" id="exampleFormControlInput1" value="<?php echo $row3['sectionEn']; ?>">
  </div>


      </div>
      <div class="modal-footer">
        <button type="submit" name="update_restr" class="btn btn-primary btn-block">تعديل القسم</button>
      </div>
      </form>

</div>


<?php require_once 'footer.php'; ?>