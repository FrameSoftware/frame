<?php

  namespace core\FrameView;

  require_once 'FrameException.php';
  require_once 'FrameLogger.php';
  
  use core\FrameException as FException;
  use core\FrameLogger as FLog;
  
  
  
  /**
   * This class is the view engine and display data in the page named layout.php which is stored in :
   * src/layout.php
   * 
   *@author simoadonis@gmail.com
   */
  class FrameView
  {
      
    private $log;
    private $file;

    public function __construct()
    {
      # code...
      $this->file = './src/layout.php';
      
      $this->log = new FLog\FrameLogger();
    }
    
    /**
     * Thie method is use by the ViewEngine to display a page (HTML)
     * 
     *@param array $data This variable hols the different informations which will be display inside the page
     *@param string $page hold the name of the page to display this page should be placed to Bundle{name}/View/{name_of_page.php} whitout .php
     *@param string $title hold the title of the page
     */
    public function rend($data = array(),$page = NULL ,$title = NULL,$header = false){
        
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

        require_once './core/ViewEngine/function.php';
        if(file_exists($this->file)){
            require_once $this->file;
            
        }else{
            $this->log->log('ERROR',$this->file);
            $ex =  new FException\FrameException(array(
                    'message'=>'Impossible de charge la fichier layout',
                    'code'=>405
                    ));
                $this->generateErrorFrameException($ex);
        }
        
    }
    
    public function render($data = array(),$page = NULL ,$title = NULL,$header = false){
        if($page == NULL){
            $page = 'layout';
        }
        $this->file = './src/'.$page.'.php';
        if(!file_exists($this->file)){
            $ex =  new FException\FrameException(array(
                    'message'=>'Impossible to find the page '.$this->file,
                    'code'=>404
                    ));
                $this->generateErrorFrameException($ex);
        } 
        require_once './core/ViewEngine/function.php';
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

        die();
    }
    
    public function generateErrorReflectionException(\ReflectionException $ex){
        //cette methode doit afficher l'erreur
        $msg = $ex->getMessage().'<br/>';
        $code = $ex->getCode();
        $fichier = $ex->getFile();
        $ligne = $ex->getLine();
        $severite = 'indefinie';
        $dump = $ex->getTrace();
//        echo '<pre>';
//        var_dump($ex->getTrace());
//        echo '</pre>--------------------';
//        foreach ($ex->getTrace() as $trace){
//            foreach ($trace as $t){
//                
//                echo '<pre>';
//                var_dump(array_keys($trace));
//                echo '[fichier]'.$trace['file'].' <br/>';
//                echo '[ligne]'.$trace['line'].' <br/>';
//                echo '[fonction]'.$trace['function'].' <br/>';
//                echo '[class]'.$trace['class'].' <br/>';
//                echo '[type]'.$trace['type'].' <br/>';
//                var_dump(array_keys($trace['args']));
//                echo '<------------>';
//                foreach ($trace['args'] as $arg):
//                    echo $arg;
//                endforeach;
//                echo '</pre>----';
//            }
//        }
        $trace = $ex->getTraceAsString();
        require_once 'core/ViewEngine/error.php';
        die();
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

        die();                                                                                                                                           
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
        die(); 
    }
  }
 ?>