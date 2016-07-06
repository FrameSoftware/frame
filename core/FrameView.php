<?php

  namespace core\FrameView;

  require_once 'FrameException.php';
  
  use core\FrameException as FException;
  /**
   * Cette classe est le moteur de template du framework
   *@author simoadonis@gmail.com
   */
  class FrameView
  {

    public function __construct()
    {
      # code...
    }
    
    public function generateErrorFrameException(FException\FrameException $ex){
        //cette methode doit afficher l'erreur
        echo 'il y a eu erreur ici ['.$ex->getMessage().']<br/>';
    }
  }



 ?>
