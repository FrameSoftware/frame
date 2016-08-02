<?php

include_once './core/FrameController.php';

use core\FrameController as FController;

class ControlleurDefault extends  FController\FrameController {
    public function indexAction(){
	//echo 'Je suis le controlleur par defaut  de BundleDefault et je fonctionne';
        //$this->cache->addToCache('f');
        $form = $this->loadModule('form');
        //$field = $this->loadModule('field');
        ob_start();
        
        $form->open();
        $form->setNom('');
        $form->add_fieldln(array(
            'name'=>'nom',
            'id'=>'id',
            'label'=>'adoni5'
        ))->add_fieldln(array(
            'name'=>'nom',
            'id'=>'id'
        ));
        
        $form->close();
        
        echo ob_get_clean();
        //$field = $this->loadModule('fieldd');
        //echo $form->output();
        echo $form->getHash();
        $this->logger->log('WARNING','zsKKf');
    }
}