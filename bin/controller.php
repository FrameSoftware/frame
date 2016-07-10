<?php 

include_once '../../core/FrameController.php';

namespace BundleDefault;

use core\FrameController as FController;

class ControlleurDefault extends  FController\FrameController {
    public function index(){
        echo 'Je suis le controlleur [nom du controlleur] et je fonctionne';
    }
}
