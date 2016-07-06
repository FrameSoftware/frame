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
        $msg =  $ex->getMessage().'<br/>';
        $code = $ex->getCode();
        $fichier = $ex->getFile();
        $ligne = $ex->getLine();
        $severite = $ex->getSeverity();
        $dump = ($ex->getTrace());
        $trace = $ex->getTraceAsString();
        require_once 'core/ViewEngine/error.php';
    }
    
    public function generateErrorReflectionException(\ReflectionException $ex){
        //cette methode doit afficher l'erreur
        $msg = $ex->getMessage().'<br/>';
        $code = $ex->getCode();
        $fichier = $ex->getFile();
        $ligne = $ex->getLine();
        $severite = 'indefinie';
        $dump = $ex->getTrace();
        $trace = $ex->getTraceAsString();
        require_once 'core/ViewEngine/error.php';
    }
  }



 ?>
