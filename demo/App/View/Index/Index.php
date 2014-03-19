<?php
$data = array(
    'title' => 'Welcome',
);
View::tplInclude('Public/header', $data); ?>
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
<main class="bs-masthead" id="content" role="main">
  <div class="container">
    <h1>SinglePHP</h1>
    <p class="lead">单文件PHP框架，羽量级网站开发首选</p>
    <blockquote>
<p>本项目由<a href='http://leo108.com' target='_blank'>leo108</a>开发，遵循GPLv2协议。</p>
    <p>当前文档更新日期为：2014年3月19日</p>
    </blockquote>
    <p>
      <a href="https://github.com/leo108/SinglePHP" target='_blank' class="btn btn-outline-inverse btn-lg" >Fork On Github</a>
      <a href="./index.php?a=start" class="btn btn-outline-inverse btn-lg">开始看文档</a>
    </p>
  </div>
</main><?php View::tplInclude('Public/footer'); ?>
