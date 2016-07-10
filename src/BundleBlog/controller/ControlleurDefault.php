<?php
include_once './core/FrameController.php';

use core\FrameController as FController;

class ControlleurDefault extends  FController\FrameController {
    public function index(){
	echo 'Je suis le controlleur par defaut  de BundleBlog et je fonctionne';
    }
    
    public function acceuil($d){
        echo 'acceuil'.$d['id'];
    }
}