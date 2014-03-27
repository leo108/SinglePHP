<?php
$data = array(
    'title' => 'Welcome',
    'body_class' => 'bs-docs-home',
);
View::tplInclude('Public/header', $data); ?>
<main class="bs-masthead" id="content" role="main">
  <div class="container">
    <h1>SinglePHP</h1>
    <p class="lead">单文件PHP框架，羽量级网站开发首选</p>
    <blockquote>
<p>本项目由<a href='http://leo108.com' target='_blank'>leo108</a>开发，遵循GPLv2协议。</p>
    <p>当前文档更新日期为：2014年3月27日</p>
    </blockquote>
    <p>
      <a href="https://github.com/leo108/SinglePHP" target='_blank' class="btn btn-outline-inverse btn-lg" >Fork On Github</a>
      <a href="./index.php?a=start" class="btn btn-outline-inverse btn-lg">开始看文档</a>
    </p>
  </div>
</main>
<?php View::tplInclude('Public/footer'); ?>
