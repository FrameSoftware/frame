<?php

  namespace core\FrameController;
  
  require_once 'FrameView.php';
  require_once 'FrameException.php';
  require_once 'FrameLogger.php';
  require_once 'FrameCache.php';
  
  use core\FrameView as FView;
  use core\FrameException as FException;
  use core\FrameCache as FCache;
  use core\FrameLogger as FLog;

  /**
   * Cette classe est le controlleur par defaut de tout le framework il contient
   * toutes les methodes que devront implementer les autres controlleur
   *@author simoadonis@gmail.com
   */
  abstract class FrameController
  {
      protected $view;
      private $bd;
      private $log;
      private $entity;
      private $entity_name;
      private $module;
      protected $cache;
      private $manager;
      private $manager_name;
      protected $logger;


      public function __construct($argument = null)
    {
        //we start to load the different engine
        $this->view =  new FView\FrameView();
        $this->cache = new FCache\FrameCache();
        $this->logger = new FLog\FrameLogger();
    }
    
    public function loging(){
        return $this->logger;
    }
    
    public function cache(){
        return $this->cache;
    }
    
    public function view(){
        return $this->view;
    }
    
    /**
     * 
     * @param string $module contain the name of the module to load which is located to core/module/
     */
    public function loadModule($module){
        $module = ucfirst(strtolower($module));
        $module_class = ucfirst(strtolower($module));
        $this->module = './core/module/'.$module.'.php';
        if(file_exists($this->module)){
            require_once $this->module;
            $m = new $module_class;
            echo 'f';
            return new $module_class;
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Unable to find the manager specified',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    /**
     * Return a class of manager which id passed as argument
     * @param type $manager
     */
    public function loadManager($manager){
        $manager = ucfirst(strtolower($manager));
        $this->manager = './src/Manager/'.$manager.'.php';
        if(file_exists($this->manager)){
            require_once $this->manager;
            return new $this->manager;
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Unable to find the manager specified',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    /**
     * Return the class which is passed as argument
     * @param type $entity
     */
    public function loadEntity($entity ){
        $entity = ucfirst(strtolower($entity));
        $this->entity = './src/Entity/'.$entity.'.php';
        if(file_exists($this->entity)){
            require_once $this->entity;
            return new $this->entity;
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Unable to find the manager specified',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    abstract public function indexAction();
  }
 