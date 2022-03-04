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
	  <li class="nav-item">
        <a class="nav-link" href="home"> الطلبات </a>

      </li>
      <li class="nav-item">
        <a class="nav-link" href="restr"> المطاعم </a>

      </li>

      <li class="nav-item">
        <a class="nav-link" href="section"> الاقسام </a>

      </li>

    
	  
      </ul>
<ul class="navbar-nav ml-auto nav-flex-icons">
<li class="nav-item">
        <a class="nav-link" href="../adminEn"><i class="fas fa-globe-americas"></i> En </a>

      </li>
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