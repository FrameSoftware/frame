<?php
include_once './core/FrameController.php';

use core\FrameController as FController;

class ControlleurDefault extends  FController\FrameController {
	public function index(){
	echo 'Je suis le controlleur par defaut  de BundleDocumentation et je fonctionne';
  }
}