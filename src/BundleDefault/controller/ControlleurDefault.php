<?php

include_once './core/FrameController.php';

use core\FrameController as FController;

class ControlleurDefault extends  FController\FrameController {
    
    public function indexAction(){
        echo "je suis le bundle default et je fonctionne";
    }
    
    
}