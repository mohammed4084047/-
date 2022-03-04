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
    $sql="INSERT INTO section(sectionAr,sectionEn) VALUES('$sectionAr','$sectionEn')";
    $res7 = mysqli_query($db,$sql);
    
      if ($res7) {
        $errTyp = "success";
        $sucMSG = "تمت إضافة القسم بنجاح";
        header("refresh:3;section");
              } else {
                  $errTyp = "danger";
                  $errMSG = "حدث خطاء";	
              }
  
  
      }
  }

  $query2 = "SELECT * FROM section";
	$result2 = mysqli_query($db, $query2);

  
  if(isset($_GET['delete']))
  {
  $query4 = "DELETE FROM section WHERE sID =".$_GET['delete'];
  $results4 = mysqli_query($db, $query4);
  if ($results4) {
    ?>
  <script>
  alert('تم مسح القسم بنجاح');
    window.location.href='section';
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
  <h3 class="p-0"><i class="fas fa-utensils"></i> الأقسام 
  <button type="button" class="btn btn-outline-light float-right mt-0" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> قسم جديد</button>
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
<center>
  <div class="card-body">
    <h5 class="card-title"><?php echo $row2['sectionAr']; ?></h5>
   <!-- <p class="card-text">Some quick example.</p> -->
    <div class="btn-group" role="group" aria-label="Basic example">
  <a type="button" href="editSection?sID=<?php echo $row2['sID']; ?>" class="btn btn-outline-warning btn-sm"><i class="far fa-edit"></i> تعديل</a>
  <a type="button" href="?delete=<?php echo $row2['sID']; ?>"  onclick="return confirm('هل تريد مسح القسم؟')" class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i> مسح</a>
</div>
  </div>
  </center>
</div> 
        </div>

 <?php } ?> 
</div> <?php } else { ?>
  <div class="alert alert-danger alert-dismissible  bg-danger text-white fade show px-3" style="border:none; border-radius:0px;" role="alert">
  <i class="fas fa-exclamation-triangle"></i>&nbsp; <strong>لا توجد أقسام </strong> 
</div>
 <?php } ?>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">إضافة قسم جديد</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="modal-body">
      
  <div class="form-group">
    <label for="exampleFormControlInput1">إسم القسم بالعربي</label>
    <input type="text" class="form-control" name="sectionAr" id="exampleFormControlInput1" placeholder="البرغر">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">إسم القسم بالإنجليزي</label>
    <input type="text" class="form-control" name="sectionEn" id="exampleFormControlInput1" placeholder="Burger">
  </div>

      </div>
      <div class="modal-footer">
        <button type="submit" name="add_restr" class="btn btn-primary btn-block">حفظ القسم</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php require_once 'footer.php'; ?>