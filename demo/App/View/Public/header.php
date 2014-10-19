<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="author" content="leo108">
    <title><?php echo $title;?></title>
    <meta name="description" content="SinglePHP" />
    <link href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://v3.bootcss.com/assets/css/docs.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/highlight.js/7.3/styles/github.min.css" rel="stylesheet">
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <?php
    if(isset($css)) foreach($css as $path){
        echo "<link rel='stylesheet' href='$path'>";
    }
    if(isset($js)) foreach($js as $path){
        echo "<script src='$path'></script>";
    }
    ?>
</head>
<body <?php if(isset($body_class)){echo "class='{$body_class}'";}?>>
    <header class="navbar navbar-static-top bs-docs-nav" id="top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="./" class="navbar-brand">SinglePHP</a>
    </div>
    <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">
         <li>
            <a href='index.php?a=Url'>Normal方式路由</a>
         </li>
         <li>
            <a href='index.php?a=Redirect'>重定向</a>
         </li>
         <li>
            <a href='index.php?a=Ajax'>Ajax返回</a>
         </li>
         <li>
            <a href='index.php?a=Common'>Common文件自动加载</a>
         </li>
         <li>
            <a href='index.php?a=AutoLoad'>类自动加载</a>
         </li>
         <li>
            <a href='index.php?a=Widget'>Widget</a>
         </li>
         <li>
            <a href='index.php?a=Log'>日志</a>
         </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a target='_blank' href="https://github.com/leo108/SinglePHP">SinglePHP官网</a>
        </li>
      </ul>
    </nav>
  </div>
</header>
