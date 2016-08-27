<?php

  namespace core\FrameController;
  
  //require_once '/definition.php';
//  require_once 'FrameView.php';
//  require_once 'FrameException.php';
//  require_once 'FrameLogger.php';
//  require_once 'FrameCache.php';
  
  use core\FrameView as FView;
  use core\FrameException as FException;
  use core\FrameCache as FCache;
  use core\FrameLogger as FLog;
  //use core\module\Form as Form;

  /**
   * Cette classe est le controlleur par defaut de tout le framework il contient
   * toutes les methodes que devront implementer les autres controlleur
   * 
   * Now i will introduce the auto_loading concept in the controlleur it means that the developper will
   * have to write the list of module he want to load automatically by the controller. 
   * 
   * *------------------------------------*
   * | HOW IT WORKS                       |
   * *------------------------------------*
   * 
   * the controller will autoload the file autoload.php and different attrbut
   * like : $module_loaded will containt the instance of module.
   * 
   * to use it you have to call a function and this function
   * varie in the case you want an module, entity, class or manager :
   * 
   * entity : _entity({name})
   * manager : _manager({name})
   * class : _class({name})
   * module : _module({name})
   * 
   * It is advice to use this method like this : 
   * e.g. case of manager student and the calling of geStudentList() method:
   * 
   * $list = $this->_manager('student')->getStudentList() ;
   *    instead of :
   * $etudian_manager = $this->_manager('student');
   * $list = $student_manager->getStudentList();
   * 
   * the second way todo spend time , lines of code and memory to works
   * 
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
      
      protected $mod_autoloaded= false;
      protected $man_autoloaded= false;
      protected $class_autoloaded= false;
      protected $entity_autoloaded = false;

      /**
       * Will hold instance of module which will be autoload
       *
       * @var type array
       */
      protected $module_loaded = array();
      
      /**
       * Will hold the instance of class which will be autoloaded
       *
       * @var type array
       */
      protected $class_loaded = array();
      
      /**
       * Will hold instance of entity which will be autoloaded
       *
       * @var type array
       */
      protected $entity_loaded = array();
      
      /**
       * Will hold instance of manager which will be autoloaded
       *
       * @var type array
       */
      protected $manager_loaded = array();



      public function __construct($argument = null)
    {
        //we start to load the different engine
        $this->view =  new FView\FrameView();
        $this->cache = new FCache\FrameCache();
        $this->logger = new FLog\FrameLogger();
        
        define('CSS', 'assets/css/');
        define('JS', 'assets/JS/');
        define('IMG', 'assets/img/');
        define('ASSETS','/assets/');
        $this->start_autolading();
        
        
        // at this level the autoloading is finish
    }
    
    public function start_autolading(){
        require_once './src/config/autoload.php';
        $this->autoloaded = TRUE;
        //will start the autoloading at this place by reading first the autoload file 
        //the manager 
        $list_manager = (!empty($autoload['manager']) && isset($autoload['manager'])) ? $autoload['manager'] : NULL;
        
        $list_entity = (!empty($autoload['entity']) && isset($autoload['entity']))  ? $autoload['entity']  : NULL;
        $list_class = (!empty($autoload['class']) && isset($autoload['class']))  ? $autoload['class']  : NULL;
        $list_module = (!empty($autoload['modules']) && isset($autoload['modules']))  ? $autoload['modules']  : NULL;
        
        
        //if there is a list of modules to load we just toured the whole list 
        //and initialise objet whith tha appropriate methode
        if($list_manager != NULL){
            empty($this->manager_loaded);
            foreach ($list_manager as $manager){
                $manager = ucfirst(strtolower($manager));
                $this->manager_loaded[$manager] = $this->loadManager($manager);
            }
            $this->man_autoloaded = true;
        }
        
        if($list_entity != NULL){
            empty($this->entity_loaded);
            foreach ($list_entity as $entity){
                $entity = ucfirst(strtolower($entity));
                
                $this->entity_loaded[$entity] = $this->loadEntity($entity);
            }
            $this->entity_autoloaded = true;
        }
        
        if($list_module != NULL){
            
            empty($this->module_loaded);
            foreach ($list_module as $mods){
                $mods = ucfirst(strtolower($mods));
                $this->module_loaded[$mods] = $this->loadModule($mods);
                
            }
            $this->mod_autoloaded = true;
        }
        
        if($list_class != NULL){
            empty($this->class_loaded);
            foreach ($list_class as $class){
                $class = ucfirst(strtolower($class));
                $this->class_loaded[$class] = $this->loadClass($class);
            }
            $this->class_autoloaded = true;
        }
     
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
    public function loadModule($module, $data = NULL){
        $module = ucfirst(strtolower($module));
        $module_class = ucfirst(strtolower($module));
        $this->module = './core/module/'.$module.'.php';
        //echo $module_class;
        if(file_exists($this->module)){
            $a = require_once $this->module;
            if($data != NULL){
                return new $module_class($data);
            }
            return new $module_class();
            
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
    public function loadManager($manager, $data = NULL){
        $manager = ucfirst(strtolower($manager));
        $this->manager = './src/Manager/'.$manager.'Manager.php';
        if(file_exists($this->manager)){
            require_once $this->manager;
            $manager_class = $manager.'Manager';
            if($data != NULL){
                return new $manager_class($data);
            }
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
    public function loadEntity($entity , $data = NULL){
        $entity = ucfirst(strtolower($entity));
        
        $this->entity = './src/Entity/'.$entity.'Entity.php';
        if(file_exists($this->entity)){
            require_once $this->entity;
            $entity_class = $entity.'Entity';
            if($data == NULL){
                return new $entity_class();
            }else{
                return new $entity_class($data);
            }
            
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Unable to find the specified entity',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
        
    /**
     * This function load a class stored at ./src/Class/{$class}.Class.php file
     * and return a instance of it
     * 
     * @param string $class
     * @return \core\FrameController\class_name
     */
    public function loadClass($class, $data = NULL){
        $class = ucfirst(strtolower($class));
        $class_name = $class.'Class';
        $class_path = './src/Class/'.$class.'Class.php';
        if(file_exists($class_path)){
            require_once $class_path;
            if($data != NULL){
                return new $class_name($data);
            }
            return new $class_name();
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Unable to find the specified class',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    
    
    /**
     * Return the instance of module which has been autoloaded
     * 
     * @param type $name
     * @return type instance of a module 
     */
    public function _module($name){
        //return (isset($this->module_loaded[$name]) ? $this->module_loaded[$name] : NULL );
        $name = ucfirst(strtolower($name));
        
        if(isset($this->module_loaded[$name])){
            //echo $this->module_loaded[$name];
            return $this->module_loaded[$name];
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Instance of  module '.$name.'. not found  Hint:  may it has not declared to be  autoloaded',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    public function _set_module($name,$module){
        //return (isset($this->module_loaded[$name]) ? $this->module_loaded[$name] : NULL );
        $name = ucfirst(strtolower($name));
        
        if(isset($this->module_loaded[$name])){
            //echo $this->module_loaded[$name];
            $this->module_loaded[$name] = $module;
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Instance of  module '.$name.'. not found  Hint:  may it has not declared to be  autoloaded',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    /**
     * Return an instance of a manager which has been autoloaded
     * 
     * @param type $name
     * @return type
     */
    public function _manager($name){
        //return (isset($this->manager_loaded[$name]) ? $this->module_loaded[$name] : NULL );
        $name = ucfirst(strtolower($name));
        if(isset($this->manager_loaded[$name])){
            return $this->manager_loaded[$name];
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Instance of  manager '.$name.'. not found  Hint:  may it has not declared to be  autoloaded',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    public function _set_manager($name,$menager){
        //return (isset($this->manager_loaded[$name]) ? $this->module_loaded[$name] : NULL );
        $name = ucfirst(strtolower($name));
        if(isset($this->manager_loaded[$name])){
            $this->manager_loaded[$name] = $menager;
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Instance of  manager '.$name.'. not found  Hint:  may it has not declared to be  autoloaded',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    /**
     * Return an instance of a class which has been autoloaded
     * 
     * @param type $name
     * @return type
     */
    public function _class($name){
        //return (isset($this->class_loaded[$name]) ? $this->module_loaded[$name] : NULL );
        $name = ucfirst(strtolower($name));
        if(isset($this->class_loaded[$name])){
            return $this->class_loaded[$name];
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Instance of class '.$name.'. not found  Hint:  may it has not declared to be  autoloaded',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    public function _set_class($name,$class){
        $name = ucfirst(strtolower($name));
        if(isset($this->class_loaded[$name])){
            
            $this->class_loaded[$name] = $class;
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Instance of class '.$name.'. not found  Hint:  may it has not declared to be  autoloaded',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    /**
     * Return an instance of a entity which has been autoloaded
     * 
     * @param type $name
     * @return type
     */
    public function _entity($name){
        //return (isset($this->entity_loaded[$name]) ? $this->module_loaded[$name] : NULL );
        $name = ucfirst(strtolower($name));
        if(isset($this->entity_loaded[$name])){
            return $this->entity_loaded[$name];
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Instance of entity '.$name.'. not found  Hint:  may it has not declared to be  autoloaded',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }
    
    public function _set_entity($name,$entity){
        $name = ucfirst(strtolower($name));
        if(isset($this->entity_loaded[$name])){
            $this->entity_loaded[$name] = $entity;
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Instance of entity '.$name.'. not found  Hint:  may it has not declared to be  autoloaded',
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
    
    /**
     * This methode will be responsible of the redirection in the application
     * It has 3 parameters
     * 
     * @param string $bundle
     * @param string $controller
     * @param string $method = null
     * @param string $args Hols and array list of argument passed to a method during the redirection request
     * 
     * the last parameter has to be use like this :
     * 
     * array(
     *  'parameter' => 'value'
     * )
     * 
     */
    public function redirect($bundle, $controller, $method = NULL , $args = NULL){
        $addr = 'location:http://'.APP.'/'.$bundle.'/'.$controller;
        if($method != NULL){
            $addr .= '/'.$method;
        }
        
        if($args!= NULL){
            $a = "";
            //foreach ($args as $arg->$val){
              //  $a =
            //}
            $addr .= '/?'.$args;
        }
        
        //start the redirection here
        header($addr);
    }

    abstract public function indexAction();
  }
 