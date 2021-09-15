<?php
include 'call/cone.php';
include 'call/func.php';
include 'call/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $spre1.$spre2; ?> | Ingresar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index2.html"><b><?php echo $spre1; ?></b><?php echo $spre2; ?></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Inicie sesión</p>

    <form id="f_login">
      <div class="form-group has-feedback">
        <input type="text" name="usu" id="usu" class="form-control" placeholder="Usuario">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="pas" id="pas" class="form-control" placeholder="Contraseña">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group">
        <select class="form-control" name="loc" id="loc">
          <option value="">Seleccione el local</option>
          <?php
          $cl=mysqli_query($cone, "SELECT idlocal, nombre, direccion FROM local WHERE estado=1 ORDER BY nombre, direccion ASC;");
          if(mysqli_num_rows($cl)>0){
            while($rl=mysqli_fetch_assoc($cl)){
          ?>
          <option value="<?php echo $rl['idlocal']; ?>"><?php echo utf8_encode($rl['nombre'])." - ".utf8_encode($rl['direccion']); ?></option>
          <?php
            }
          }
          mysqli_free_result($cl);
          ?>
        </select>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" id="b_login" class="btn btn-danger btn-block btn-flat">Ingresar</button>
        </div>
        <!-- /.col -->
        <div class="col-xs-12" id="r_login" style="padding: 10px;">
          
        </div>
        <!-- /.col -->
      </div>
    </form>
    <a href="#">Olvide mi contraseña</a><br>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="dist/js/in.js"></script>
</body>
</html>
