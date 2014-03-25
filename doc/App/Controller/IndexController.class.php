<?php
class IndexController extends BaseController {
    public function IndexAction(){
        $this->display();
    }
    public function StartAction(){
        $this->display();
    }
    public function DocAction(){
        $this->display();
    }
    public function InfoAction(){
        phpinfo();
    }
}
