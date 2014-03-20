<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="author" content="leo108">
    <title><?php echo $title;?></title>
    <meta name="description" content="SinglePHP" />
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://v3.bootcss.com/docs-assets/css/docs.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/highlight.js/7.3/styles/github.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
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
    <header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
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
          <a href="./index.php?a=start">起步</a>
        </li>
        <li>
          <a href="./css">CSS</a>
        </li>
        <li>
          <a href="./components">组件</a>
        </li>
        <li>
          <a href="./javascript">JavaScript插件</a>
        </li>
        <li>
          <a href="./customize">定制</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="./about">关于</a>
        </li>
      </ul>
    </nav>
  </div>
</header>
