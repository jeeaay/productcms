<?php
/*
 * @Author: Jeay 
 * @Date: 2017-11-11 15:06:32 
 * @Last Modified by: Jeay
 * @Last Modified time: 2017-11-11 15:27:19
 */
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php/*  if ( $_SERVER['SERVER_ADDR'] !="127.0.0.1" && !isset($_SESSION['psw'])) { */?>
    <?php if ( !isset($_SESSION['psw'])) {?>
    <title>请验证身份</title>
</head>
<body>
    <div class="container">
        <form method="post">
            <div class="form-group">
                <label for="Password">请验证身份</label>
                <input type="password" class="form-control" id="Password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-default">提交</button>
        </form>
    </div>
    <?php } else {?>
    <title>产品管理</title>
</head>
<body>


    <?php }?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
  </body>
</html>
