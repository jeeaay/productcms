<?php
/*
 * @Author: Jeay 
 * @Date: 2017-11-11 15:06:32 
 * @Last Modified by: Jeay
 * @Last Modified time: 2017-11-11 15:27:19
 */
session_start();
$psw = '12';
$padmin = new Padmin();
if ( isset($_POST['cate_name']) && isset($_POST['cate_uri'])) {
    if (trim($_POST['cate_name']) == "" || trim($_POST['cate_uri']) == "" ) {
        echo '<p class="text-error">请填写栏目名和uri</p>';
    }else {
        //写入数据库
        var_dump($padmin -> AddCate()) ;
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .cate input{width:95%}
    </style>
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
            echo "<script language=JavaScript> location.replace(location.href);</script>";
        } ?>
    <?php } else {
    //读取分类表
    $cateList = $padmin->GetCateList();
    ?>
        <div class="cate">
        <h2>产品分类</h2>
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>分类名</th>
                    <th>栏目uri</th>
                    <th>权重排序</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                //遍历现有分类
                if (!empty($cateList)) {
            ?>
                <tr>
                    <th scope="row"><?=$cateList['id']?></th>
                    <td><?=$cateList['name']?></td>
                    <td><?=$cateList['uri']?></td>
                    <td><?=$cateList['weight']?></td>
                </tr>
            <?php }else {?>
                <tr class="warning"><td colspan="4">暂无分类</td></tr>
            <?php } ?>
                <tr><td colspan="4">添加分类:</td></tr>
                <form method="post">
                <tr class="info">
                    <th scope="row">添加分类</th>
                    <td><input name="cate_name" type="text" placeholder="分类名称"></td>
                    <td><input name="cate_uri" type="text" placeholder="尽量使用英文、下划线_、减号-，Linux主机区分大小写"></td>
                    <td><input type="submit" value="提交"></td>
                </tr>
                </form>
            </tbody>
            </table>
        </div>
        

    <?php }?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
<?php
class Padmin
{
    function __construct($path = "product.db")
    {
        if (!file_exists("product.db")) {
            $sql ="
            CREATE TABLE 'Cate' (
                'id'  INTEGER PRIMARY KEY AUTOINCREMENT,
                'name'  TEXT,
                'uri' TEXT,
                'weight' INTEGER DEFAULT 0
            );
            CREATE TABLE 'Product' (
                'id'  INTEGER PRIMARY KEY AUTOINCREMENT,
                'name'  TEXT,
                'cate_id' INTEGER,
                'intro' TEXT,
                'application' TEXT,
                'material' TEXT,
                'overview' TEXT,
                'principle' TEXT,
                'specification' TEXT,
                'custom1' TEXT,
                'custom2' TEXT,
                'custom3' TEXT,
                'custom4' TEXT,
                'custom5' TEXT,
                'custom6' TEXT
            );
            ";
        }
        //使用PDO连接数据库
        try
		{
			$this->dbh=new PDO('sqlite:'.$path);
		}
		catch(PDOException $e)
		{
			try
			{
				$this->dbh=new PDO('sqlite2:'.$path);
			}
			catch(PDOException $e)
			{
				exit('发生错误！请检查php是否有当前目录写入权限或者是否安装sqlite3扩展');
			}
		}
        if (!empty($sql)) {
            if ($this->dbh->exec($sql)==0) {
                echo '<p class="text-success">成功新建数据库 <strong>product.db</strong> </p>';
            }
        }
    }
    public function GetCateList()
    {
        $sql = "SELECT * FROM Cate";
        $this->dbh->query($sql);
    }
    public function AddCate()
    {
        $cate_name = htmlspecialchars( str_replace('\'','"', strip_tags( trim($_POST['cate_name']) ) ));
        $cate_uri = htmlspecialchars( str_replace('\'','"', strip_tags( trim($_POST['cate_uri']) ) ));
        $sql = 'INSERT INTO Cate ("name", "uri") VALUES ("'.$cate_name.'","'.$cate_uri.'");';
        //,'weight'
        return $this->dbh->exec($sql);

    }
}

?>