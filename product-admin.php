<?php
/*
 * @Author: Jeay 
 * @Date: 2017-11-11 15:06:32 
 * @Last Modified by: Jeay
 * @Last Modified time: 2017-11-11 15:27:19
 */
session_start();
$psw = '12';
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php/*  if ( $_SERVER['SERVER_ADDR'] !="127.0.0.1" && !isset($_SESSION['psw'])) { */?>
    <?php if ( empty($_SESSION['psw']) && empty($_POST['psw']) )  {?>
    <title>请验证身份</title>
    <?php } else {?>
    <title>产品管理</title>
    <?php }?>
</head>
<body>
    <?php if ( !isset($_SESSION['psw']) )  {?>
        <?php if ( empty($_POST['psw']) || $_POST['psw']!=$psw ) { ?>
    <div class="container">
        <form method="post">
            <div class="form-group <?php if ( !empty($_POST['psw']) && $_POST['psw']!=$psw) { echo 'has-error'; } ?>">
                <label class="control-label" for="Password"><?php if ( !empty($_POST['psw']) && $_POST['psw']!=$psw) { echo '密码错误'; } ?></label>
                <input type="password" name='psw' class="form-control " id="Password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-default">提交</button>
        </form>
    </div>
        <?php } else{
            $_SESSION['psw']=time();
        } ?>
    <?php } else {?>

        

    <?php }?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
