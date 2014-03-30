# SinglePHP

### 简介

SinglePHP是一个单文件PHP框架，适用于简单系统的快速开发，提供了简单的路由方式，抛弃了坑爹的PHP模板，采用原生PHP语法来渲染页面,同时提供了widget功能，简单且实用。

目前SinglePHP由[leo108](http://leo108.com)开发维护，如果你希望参与到此项目中来，可以到[Github](https://github.com/leo108/SinglePHP)上Fork项目并提交Pull Request。

### 文档

中文: [http://leo108.github.io/SinglePHP/](http://leo108.github.io/SinglePHP/)

English: [http://leo108.github.io/SinglePHP/en/](http://leo108.github.io/SinglePHP/en/) (Not Finished Yet)

### Demo

在线演示：[demo](http://singlephp.sinaapp.com)

### 目录结构

    ├── App                                 #业务代码文件夹，可在配置中指定路径
    │   ├── Controller                      #控制器文件夹
    │   │   └── IndexController.class.php
    │   ├── Lib                             #外部库
    │   ├── Log                             #日志文件夹，需要写权限
    │   ├── View                            #模板文件夹
    │   │   ├── Index                       #对应Index控制器
    │   │   │   └── Index.php
    │   │   └── Public
    │   │       ├── footer.php
    │   │       └── header.php
    │   ├── Widget                          #widget文件夹
    │   │   ├── MenuWidget.class.php
    │   │   └── Tpl                         #widget模板文件夹
    │   │       └── MenuWidget.php
    │   └── common.php                      #一些共用函数
    ├── SinglePHP.class.php                 #SinglePHP核心文件
    └── index.php                           #入口文件
    
### Hello World

只需增加3个文件，即可输出hello world。

入口文件：index.php

    <?php
    include './SinglePHP.class.php';         //包含核心文件
    $config = array('APP_PATH' => './App/'); //指定业务目录为App
    SinglePHP::getInstance($config)->run();  //撒丫子跑起来啦
    
默认控制器：App/Controller/IndexController.class.php

    <?php
    class IndexController extends Controller {       //控制器必须继承Controller类或其子类
        public function IndexAction(){               //默认Action
            $this->assign('content', 'Hello World'); //给模板变量赋值
            $this->display();                        //渲染吧骚年
        }
    }
    
模板文件：App/View/Index/Index.php

    <?php echo $content;
    
在浏览器访问index.php，应该会输出

    Hello World
