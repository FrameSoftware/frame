<?php

  namespace core\FrameController;
  
  //require_once '/definition.php';
  require_once 'FrameView.php';
  require_once 'FrameException.php';
  require_once 'FrameLogger.php';
  require_once 'FrameCache.php';
  
  use core\FrameView as FView;
  use core\FrameException as FException;
  use core\FrameCache as FCache;
  use core\FrameLogger as FLog;
  //use core\module\Form as Form;

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
      private $i;

      public function __construct($argument = null)
    {
        //we start to load the different engine
        $this->view =  new FView\FrameView();
        $this->cache = new FCache\FrameCache();
        $this->logger = new FLog\FrameLogger();
        
        //echo $argument;
        $num = "";
        $this->i = $_GET['i'];

        //for($c=0 ; $c < $this->i ;$c++){
          //$num .= '../';
        //  echo $num;
        //}

        $c = 0;
        while ($c < $this->i) {
          # code...
          $num = '../';
          //cho $num.$c;
          $c++;
        }

        define('CSS', 'assets/css/');
        define('JS', 'assets/JS/');
        define('IMG','assets/img/');
        define('ASSETS','assets/');
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
        //echo $module_class;
        if(file_exists($this->module)){
            $a = require_once $this->module;
            $m = new $module_class();
            return $m;
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Unable to find the specified module',
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
        $this->manager = './src/Manager/'.$manager.'Manager.php';
        if(file_exists($this->manager)){
            require_once $this->manager;
            $manager_class = $manager.'Manager';
            return new $manager_class();
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Unable to find the specified manager',
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
        $this->entity = './src/Entity/'.$entity.'Entity.php';
        if(file_exists($this->entity)){
            require_once $this->entity;
            $entity_class = $entity.'Entity';
            return new $entity_class();
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Unable to find the specified entity',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    public function ressources($bundle , $res ,$data = NULL){
        $path = './src/Bundle'. ucfirst(strtolower($bundle)) .'/view/'.$res.'.php';
        if(file_exists($path)){
            require_once $path;
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Impossible de trouver la ressources ['.$res.'] du bundle ['. $bundle.']',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    public function includ($bundle , $res , $data =NULL){
        ob_start();
        $this->ressources($bundle, $res,$data);
        return ob_get_clean();
    }
    
    public function setNumber($i){
      
      $this->i = $i;


    }

    abstract public function indexAction();
  }
 