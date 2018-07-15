<?php
namespace app\index\controller;
use think\Controller;
class Setmeal extends Controller
{
    public function index(){
        return $this->fetch();
    }

    public function submits(){
        return $this->fetch();
    } 

    public function succes(){
        return $this->fetch();
    } 

    // public function error(){
    //     return $this->fetch();
    // } 
}