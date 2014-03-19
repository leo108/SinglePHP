<?php
class BaseController extends Controller{
    protected function _init(){
        header("Content-Type:text/html; charset=utf-8");
    }
} 
