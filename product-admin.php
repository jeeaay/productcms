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
//权重修改
if ( isset($_SESSION['psw']) && isset($_POST['cateweight']) && is_numeric($_POST['cateweight']) ) {
    $padmin -> EditWeight();
    header('Content-type:text/json');
    exit(json_encode(['error'=>false]));
}
/* //发布接口
if ( isset($_SESSION['psw']) && isset($_POST['pro-name']) && trim($_POST['pro-name']) != "" ) {
    $padmin -> AddProduct();
    header('Content-type:text/json');
    exit(json_encode(['error'=>false]));
} */
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .cate input{width:95%}
    </style>
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
    <?php } elseif(@$_GET['pro']=="add") {
        if ( isset($_POST['pro-name']) && trim($_POST['pro-name']) != "" ) {
            echo $padmin->AddProduct();
        }else{
            $cateList = $padmin->GetCateList();
    ?>
        <div class="container-fluid">
            <h3>添加产品</h3>
            <hr>
            <form method="post" class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">产品名称 name</label>
                        <input name="pro-name" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">进料尺寸 input</label>
                        <input name="pro-input" type="text" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">产量 capacity</label>
                        <input name="pro-capacity" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">简介 intro</label>
                        <textarea name="pro-intro" rows="4" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">应用范围 application</label>
                        <input name="pro-application" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">物料 material</label>
                        <input name="pro-material" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">产品概览 overview</label>
                        <textarea name="pro-overview" rows="4" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">工作原理 principle</label>
                        <textarea name="pro-principle" rows="4" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">栏目分类</label>
                        <select name="pro-cate" class="form-control">
                            
                        <?php   if ( empty($cateList) ) { ?>
                            <option>请先添加分类</option>
                        <?php   }else{
                                    foreach ($cateList as $value) {?>
                            <option value="<?=$value['id']?>"><?=$value['name'] == "" ? '请先添加分类' : $value['name'] ?></option>
                        <?php   }   }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">出料尺寸 output</label>
                        <input name="pro-output" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">uri 指产品页面的url，不含.html 例如posuiji crusher 不填写则和名称相同</label>
                        <input name="pro-uri" type="text" class="form-control" placeholder="可以不填写，会被urlencode转码">
                    </div>
                    <div class="form-group">
                        <label class="control-label">技术参数 specification</label>
                        <textarea name="pro-specification" rows="2" class="form-control"></textarea>
                    </div>
                    <p class="text-primary">下面是自定义字段</p>
                    <div class="form-group">
                        <label class="control-label">custom1</label>
                        <input name="pro-custom1" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">custom2</label>
                        <input name="pro-custom2" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">custom3</label>
                        <input name="pro-custom3" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">custom4</label>
                        <input name="pro-custom4" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">custom5</label>
                        <input name="pro-custom5" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">custom6</label>
                        <input name="pro-custom6" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-primary" value="提交">
                </div>
            </form>
        </div>
    <?php
        }
    }else {

    //路由部分开始
    //栏目添加
    if ( isset($_POST['cate_name']) ) {
        if (trim($_POST['cate_name']) == "" ) {
            echo '<p class="text-danger">请填写栏目名和uri</p>';
        }else {
            //写入数据库
            echo $padmin -> AddCate();
        }
    }
    //栏目删除
    if ( isset($_GET['catedel']) && is_numeric($_GET['catedel']) ) {
        echo $padmin -> DelCate();
    }
    
    //展示部分开始
    //读取分类表
    $cateList = $padmin->GetCateList();
    $proList = $padmin->GetProductList();
    ?>
        <div class="container-fluid">
            <div class="cate">
                <h2>产品分类</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>分类名</th>
                            <th>栏目uri</th>
                            <th>权重排序</th>
                            <th>删除</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        //遍历现有分类
                        if (!empty($cateList)) {
                            foreach ($cateList as $value) {
                    ?>
                        <tr>
                            <th scope="row"><?=$value['id']?></th>
                            <td><?=$value['name']?></td>
                            <td><?=$value['uri']?></td>
                            <td><input class="cateweight" data-id="<?=$value['id']?>" type="text" value="<?=$value['weight']?>" onkeypress="return (/[\d.]/.test(Math.ceil(String.fromCharCode(event.keyCode))))"></td>
                            <td><a href="?catedel=<?=$value['id']?>">删除</a></td>
                        </tr>
                    <?php   }
                        }else {
                        ?>
                        <tr class="warning"><td colspan="5">暂无分类</td></tr>
                    <?php } ?>
                        
                        <form method="post">
                        <tr class="info">
                            <th scope="row">添加分类</th>
                            <td><input name="cate_name" type="text" placeholder="分类名称"></td>
                            <td colspan="2"><input name="cate_uri" type="text" placeholder="尽量使用英文,会被urlencode转码"></td>
                            <td><input type="submit" class="btn btn-primary" value="提交"></td>
                        </tr>
                        </form>
                    </tbody>
                </table>
            </div>

            <div class="Product">
                <h2>产品列表</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>名称</th>
                            <th>分类</th>
                            <th>权重排序</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        //遍历所有产品
                        if (!empty($proList)) {
                            foreach ($proList as $value) {
                    ?>
                        <tr>
                            <th scope="row"><?=$value['id']?></th>
                            <td><?=$value['name']?></td>
                            <td><?=$value['cate']?></td>
                            <td><input class="proweight" data-id="<?=$value['id']?>" type="text" value="<?=$value['weight']?>" onkeypress="return (/[\d.]/.test(Math.ceil(String.fromCharCode(event.keyCode))))"></td>
                            <td><a href="?proedit=<?=$value['id']?>">修改</a>&nbsp;&nbsp;<a href="?prodel=<?=$value['id']?>">删除</a></td>
                        </tr>
                    <?php   }
                        }else {
                        ?>
                        <tr class="warning"><td colspan="5">暂无产品</td></tr>
                    <?php } ?>
                        <tr><td colspan="5"><a class="btn btn-primary" target="_blank" href="?pro=add">添加产品</a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        

    <?php }?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $(".cateweight").keyup(function () { 
                var data = { 'cateweight': parseInt( $(this).val() ), 'id': parseInt( $(this).attr("data-id") ) };
                $.post( window.location.href, data );
            });
        })
    </script>
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
                'name'  TEXT UNIQUE,
                'uri' TEXT UNIQUE,
                'weight' INTEGER DEFAULT 0
            );
            CREATE TABLE 'Product' (
                'id'  INTEGER PRIMARY KEY AUTOINCREMENT,
                'name'  TEXT UNIQUE,
                'uri'  TEXT UNIQUE,
                'cate_id' INTEGER,
                'weight' INTEGER,
                'capacity' TEXT,
                'input' TEXT,
                'output' TEXT,
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
        return $this->dbh->query($sql)->fetchAll();
    }
    public function AddCate()
    {
        $cate_name = htmlspecialchars( str_replace('\'','"', strip_tags( trim($_POST['cate_name']) ) ));
        if (empty($_POST['cate_uri'])) {
            $cate_uri = urlencode($cate_name);
        }else {
            $cate_uri = urlencode( htmlspecialchars( str_replace( '\'','"', strip_tags( trim($_POST['cate_uri']) ) ) ) );
        }
        //当前id
        $this->dbh->query("select seq from sqlite_sequence where name='Cate'");
        if ( $res=$this->dbh->query("select seq from sqlite_sequence where name='Cate'") ) {
            $weight = ( $res->fetch()[0] + 1 )* 5;
        }else {
            $weight = 0;
        }

        $sql = 'INSERT INTO Cate ("name", "uri" ,"weight") VALUES ("'.$cate_name.'","'.$cate_uri.'","'.$weight.'");';
        //,"weight"

        if ($this->dbh->exec($sql)) {
            return '<p class="text-success">分类 '.$_POST['cate_name'].' 添加成功</p>';
        }else {
            return '<p class="text-danger">分类 '.$_POST['cate_name'].' 添加失败</p>';
        }

    }
    public function DelCate()
    {
        if (is_numeric($_GET['catedel'])) {
            $sql = 'DELETE FROM Cate WHERE id = '.$_GET['catedel'].';';
            if ($this->dbh->exec($sql)) {
                return '<p class="text-success">分类'.$_GET['catedel'].'删除成功</p>';
            }else {
                return '<p class="text-danger">删除失败</p>';
            }
        }
    }
    public function EditWeight()
    {
        if (is_numeric($_POST['cateweight'])) {
            $sql = 'UPDATE Cate SET weight = '.$_POST['cateweight'].'  WHERE id = '.$_POST['id'].';';
            $this->dbh->exec($sql);
        }
    }
    public function GetProductList(Type $var = null)
    {
        $sql = "SELECT * FROM Product";
        return $this->dbh->query($sql)->fetchAll();
    }
    public function AddProduct()
    {
        $date = [];
        if (trim($_POST['pro-name']) == "" || trim($_POST['pro-cate']) == "") {
            return "产品名称和分类必须填写";
        }else {
            $date['name'] = str_replace( '\'','"', trim($_POST['pro-name']) );
            $date['cate'] = (int)($_POST['pro-cate']);
        }
    }
}

?>