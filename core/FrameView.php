<?php

  namespace core\FrameView;

  require_once 'FrameException.php';
  
  use core\FrameException as FException;
  
  
  
  /**
   * This class is the view engine and display data in the page named layout.php which is stored in :
   * src/layout.php
   * 
   *@author simoadonis@gmail.com
   */
  class FrameView
  {
      
    private $file;

    public function __construct()
    {
      # code...
      $file = './src/layout.php';
    }
    
    /**
     * Thie method is use by the ViewEngine to display a page (HTML)
     * 
     *@param array $data This variable hols the different informations which will be display inside the page
     *@param string $page hold the name of the page to display this page should be placed to Bundle{name}/View/{name_of_page.php} whitout .php
     *@param string $title hold the title of the page
     */
    public function rend($data = array(),$page = NULL ,$title = NULL){
        if($page!= NULL){//if the page has been set by the user
            $this->file = '../view/'.$page.'.php';
            if(file_exists($this->file)){//if the file is set
                require_once $this->file;
            }else{
                $ex =  new FException\FrameException(array(
                    'message'=>'Impossible to find the page '.$this->file,
                    'code'=>404
                    ));
                $this->generateErrorFrameException($ex);
            } 
        }
        require_once $this->file;
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
    
    public function generateErrorException(\Exception $ex){
        $msg = $ex->getMessage().'<br/>';
        $code = $ex->getCode();
        $fichier = $ex->getFile();
        $ligne = $ex->getLine();
        $severite = 'indefinie';
        $dump = $ex->getTrace();
        $trace = $ex->getTraceAsString();
        require_once 'core/ViewEngine/error.php';
    }
    
    public function generateErrorPDOExceptio(\PDOException $ex){
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