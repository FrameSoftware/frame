<?php

include_once './core/FrameController.php';

use core\FrameController as FController;

class ControlleurDefault extends  FController\FrameController {
    
    public function __construct($argument = null) {
        parent::__construct($argument);
    }

    public function indexAction(){
	echo 'Je suis le controlleur par defaut  de BundleDefault et je fonctionne';
    }

}