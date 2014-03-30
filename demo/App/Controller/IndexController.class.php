<?php
class IndexController extends BaseController {
    public function IndexAction(){
        $this->assign('title', 'SinglePHP');
        $this->display();
    }
    public function UrlAction(){
        echo 'url测试成功';
    }
    public function RedirectAction(){
        $this->redirect('http://www.baidu.com'); //302跳转到百度
    }
    public function AjaxAction(){
        $ret = array(
            'result' => true,
            'data'   => 123,
        );
        $this->AjaxReturn($ret);                //将$ret格式化为json字符串后输出到浏览器
    }
    public function CommonAction(){
        echo testFunction();
    }
    public function AutoLoadAction(){
        $t = new Test();
        echo $t->hello();
    }
    public function WidgetAction(){
        $this->display();
    }
    public function LogAction(){
        Log::fatal('something');
        Log::warn('something');
        Log::notice('something');
        Log::debug('something');
        Log::sql('something');
        echo '请到Log文件夹查看效果。如果是SAE环境，可以在日志中心的DEBUG日志查看。';
    }
}
