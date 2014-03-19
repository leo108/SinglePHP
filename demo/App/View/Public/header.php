<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="author" content="leo108">
    <title><?php echo $title;?></title>
    <meta name="description" content="SinglePHP" />
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://v3.bootcss.com/docs-assets/css/docs.css" rel="stylesheet">
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
<body class="bs-docs-home">
