<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php 
    session_start();
    include 'config/conn.php';
?>
  <head>
    <meta charset="UTF-8">
    <title>SIMONKELOR</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/forum.css">
    <link rel="stylesheet" href="assets/css/realtime.css">

    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->

    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar" id="sidebar">
    <?php
    if(isset($_SESSION['role'])){
      if($_SESSION['role'] == 'Super Admin'){
        include_once 'sidebar_navlink/superadmin.php';
      }
      elseif ($_SESSION['role'] == 'Admin Dispacher') {
        include_once 'sidebar_navlink/dispacher.php';
      }
      elseif ($_SESSION['role'] == 'Admin Pembangkit') {
        include_once 'sidebar_navlink/pembangkit.php';
      }
      elseif ($_SESSION['role'] == 'Pegawai') {
        include_once 'sidebar_navlink/pegawai.php';
      }
    }else{
      include_once 'sidebar_navlink/guest.php';
    }
    ?>
  </div>
  
  <div class="nav_responsive">
    <a href="javascript:void(0);" class="icon" onclick="sidebar_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
  <div class="main">

  <?php
  if(@$_GET['p'] == ""){
    include_once 'realtime.php';
  }elseif(@$_GET['p'] == "realtime"){
    include_once 'realtime.php';
  }elseif(@$_GET['p'] == "user_aktif"){
    include_once 'admin/super_admin/data_user_aktif.php';
  }elseif(@$_GET['p'] == "user_nonaktif"){
    include_once 'admin/super_admin/data_user_nonaktif.php';
  }elseif(@$_GET['p'] == "data_pembangkit"){
    include_once 'pembangkit.php';
  }elseif(@$_GET['p'] == "data_tegangan"){
    include_once 'tegangan.php';
  }elseif(@$_GET['p'] == "forcasting"){
    include_once 'forcasting.php';
  }elseif(@$_GET['p'] == "data_operasi"){
    include_once 'admin/super_admin/data_operasi.php';
  }elseif(@$_GET['p'] == "documentation_superadmin"){
    include_once 'admin/super_admin/documentation.php';
  }

  // forum
  elseif(@$_GET['p'] == "forum_superadmin"){
    include_once 'admin/super_admin/forum.php';
  }
  elseif(@$_GET['p'] == "forum_add"){
    include_once 'admin/super_admin/form_add_forum.php';
  }
  elseif(@$_GET['p']=="forum_update"){    
    $query=mysqli_query($koneksi,"SELECT * FROM forums WHERE id_pesan ='".$_GET['id']."'");
    while ($data = mysqli_fetch_assoc($query)) {
        include_once 'admin/super_admin/form_update_forum.php';
    }  
  }
  elseif(@$_GET['p']=="forum_delete"){
    $query=mysqli_query($koneksi,"SELECT * FROM forums WHERE id_pesan ='".$_GET['id']."'");
    $foto_lama = mysqli_fetch_array($query);

    if ($foto_lama['gambar'] == "default.jpeg") {
      $query = mysqli_query($koneksi,"DELETE FROM forums WHERE id_pesan ='".$_GET['id']."'");
    }else{
      unlink('assets/img/'.$foto_lama['gambar']);
      $query = mysqli_query($koneksi,"DELETE FROM forums WHERE id_pesan ='".$_GET['id']."'");
    }
    
    if ($query) {
        echo "<script>alert('Data telah dihapus')</script>";
        echo "<script>location='index.php?p=forum_superadmin'</script>";
    }else{
        echo "<script>alert('erorr')</script>";
    }    
  }


  elseif(@$_GET['p'] == "forum_komentar"){
    include_once 'admin/forum_komentar.php';
  }
  elseif(@$_GET['p'] == "delete_komentar_superadmin"){
    $sql=mysqli_query($koneksi,"SELECT * FROM komentars WHERE id_komentar ='".$_GET['id']."'");
    $data_komentar = mysqli_fetch_array($sql);
    $query = mysqli_query($koneksi,"DELETE FROM komentars WHERE id_komentar='".$_GET['id']."'");

    if ($query) {
        echo "<script>alert('Data telah dihapus')</script>";
        echo "<script>location='index.php?p=forum_superadmin'</script>";
    }else{
        echo "<script>alert('erorr')</script>";
    }

  }
  elseif(@$_GET['p'] == "delete_komentar"){
    $sql=mysqli_query($koneksi,"SELECT * FROM komentars WHERE id_komentar ='".$_GET['id']."'");
    $data_komentar = mysqli_fetch_array($sql);
    $query = mysqli_query($koneksi,"DELETE FROM komentars WHERE id_komentar='".$_GET['id']."'");

    if ($query) {
        echo "<script>alert('Data telah dihapus')</script>";
        echo "<script>location='index.php?p=forum_komentar'</script>";
    }else{
        echo "<script>alert('erorr')</script>";
    }

  }
  ?>
  </div>

</body>
</html>

<script src="assets/js/index.js"></script>
<!-- <script src="assets/js/langgam_beban.js"></script> -->