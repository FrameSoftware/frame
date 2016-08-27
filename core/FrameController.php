<?php

    /**
     * Frame - A lightweight PHP framework
     */

    namespace Frame\Core;
    
    /**
     * Cette classe est le controlleur par defaut de tout le framework il contient
     * toutes les methodes que devront implementer les autres controlleur
     *
     * Now i will introduce the auto_loading concept in the controlleur it means that the developper will
     * have to write the list of Module he want to load automatically by the controller.
     *
     * *------------------------------------*
     * | HOW IT WORKS                       |
     * *------------------------------------*
     *
     * the controller will autoload the file autoload.php and different attrbut
     * like : $module_loaded will containt the instance of Module.
     *
     * to use it you have to call a function and this function
     * varie in the case you want an Module, entity, class or manager :
     *
     * entity : _entity({name})
     * manager : _manager({name})
     * class : _class({name})
     * Module : _module({name})
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
     * @author simoadonis@gmail.com
     */
    class Controller
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
    
        protected $mod_autoloaded = false;
        protected $man_autoloaded = false;
        protected $class_autoloaded = false;
        protected $entity_autoloaded = false;
    
        /**
         * Will hold instance of Module which will be autoload
         *
         * @var array
         */
        protected $module_loaded = array();
    
        /**
         * Will hold the instance of class which will be autoloaded
         *
         * @var array
         */
        protected $class_loaded = array();
    
        /**
         * Will hold instance of entity which will be autoloaded
         *
         * @var array
         */
        protected $entity_loaded = array();
    
        /**
         * Will hold instance of manager which will be autoloaded
         *
         * @var array
         */
        protected $manager_loaded = array();

        /**
         * @static Controller
         */
        private static $instance;

        /**
         * @return Controller
         */
        public static function getInstance()
        {
            return (self::$instance instanceof Controller) ? self::$instance : (self::$instance = new Controller());
        }
    
        protected function __construct($argument = null)
        {
            //we start to load the different engine
            $this->view = new FrameView();
            $this->cache = new Cache();
            $this->logger = new FrameLogger();
    
            $this->start_autolading();
        }
    
        public function start_autolading()
        {
            if (file_exists(FRAME_CONFIG_PATH . '/autoload.php')) {

                require_once FRAME_CONFIG_PATH . '/autoload.php';

                $autoload = isset($autoload) ? $autoload : array();

                $list_manager = array_key_exists('manager', $autoload) ? $autoload['manager'] : array();
                $list_entity = array_key_exists('entity', $autoload) ? $autoload['entity'] : array();
                $list_class = array_key_exists('class', $autoload) ? $autoload['class'] : array();
                $list_module = array_key_exists('modules', $autoload) ? $autoload['modules'] : array();


                //if there is a list of modules to load we just toured the whole list
                //and initialise objet whith tha appropriate methode
                if (count($list_manager) > 0) {
                    $this->manager_loaded = array();
                    foreach ((array)$list_manager as $manager) {
                        $manager = ucfirst(strtolower($manager));
                        $this->manager_loaded[$manager] =& $this->loadManager($manager);
                    }
                    $this->man_autoloaded = true;
                }

                if (count($list_entity) > 0) {
                    $this->entity_loaded = array();
                    foreach ((array)$list_entity as $entity) {
                        $entity = ucfirst(strtolower($entity));
                        $this->entity_loaded[$entity] =& $this->loadEntity($entity);
                    }
                    $this->entity_autoloaded = true;
                }

                if (count($list_module) > 0) {
                    $this->module_loaded = array();
                    foreach ((array)$list_module as $mods) {
                        $mods = ucfirst(strtolower($mods));
                        $this->module_loaded[$mods] =& $this->loadModule($mods);
                    }
                    $this->mod_autoloaded = true;
                }

                if (count($list_class) > 0) {
                    $this->class_autoloaded = array();
                    foreach ((array)$list_class as $class) {
                        $class = ucfirst(strtolower($class));
                        $this->class_loaded[$class] =& $this->loadClass($class);
                    }
                    $this->class_autoloaded = true;
                }
            }
        }
    
        public function loging()
        {
            return $this->logger;
        }
    
        public function cache()
        {
            return $this->cache;
        }
    
        public function view()
        {
            return $this->view;
        }
    
        /**
         *
         * @param string $module contain the name of the Module to load which is located to core/Module/
         */
        public function loadModule($module, $data = NULL)
        {
            $class = 'Frame\\Core\\Module\\' . $module;
            $path  = FRAME_CORE_PATH . '/Module/' . $module . '.php';
            if (file_exists($path)) {
                if (!class_exists($class)) {
                    require_once $path;
                }
                if ($data !== NULL) {
                    return new $class($data);
                }
                return new $class();
    
            }
            throw new Exception(array(
                'message' => 'Unable to find the specified Module',
                'status' => 404
            ));
        }
    
        /**
         * Return a class of manager which id passed as argument
         * @param string $manager
         */
        public function loadManager($manager, $data = NULL)
        {
            $class = '\\' . $manager . 'Manager';
            $path  = FRAME_MANAGER_PATH . '/' . $manager . 'Manager.php';
            if (file_exists($path)) {
                if (!class_exists($class)) {
                    require_once $path;
                }
                if ($data !== NULL) {
                    return new $class($data);
                }
                return new $class();
            }
            throw new Exception(array(
                'message' => 'Unable to find the specified manager',
                'status'  => 404
            ));
        }
    
        /**
         * Return the class which is passed as argument
         * @param type $entity
         */
        public function loadEntity($entity, $data = NULL)
        {
            $entity = ucfirst(strtolower($entity));
    
            $this->entity = './src/Entity/' . $entity . 'Entity.php';
            if (file_exists($this->entity)) {
                require_once $this->entity;
                $entity_class = $entity . 'Entity';
                if ($data == NULL) {
                    return new $entity_class();
                } else {
                    return new $entity_class($data);
                }
    
            } else {
                $ex = new Exception(array(
                    'message' => 'Unable to find the specified entity',
                    'status' => 404
                ));
                $this->view->generateErrorFrameException($ex);
            }
        }
    
        /**
         * This function load a class stored at ./src/Class/{$class}.Class.php file
         * and return a instance of it
         *
         * @param string $class
         * @return \class_name
         */
        public function loadClass($class, $data = NULL)
        {
            $class = ucfirst(strtolower($class));
            $class_name = $class . 'Class';
            $class_path = './src/Class/' . $class . 'Class.php';
            if (file_exists($class_path)) {
                require_once $class_path;
                if ($data != NULL) {
                    return new $class_name($data);
                }
                return new $class_name();
            } else {
                $ex = new Exception(array(
                    'message' => 'Unable to find the specified class',
                    'status' => 404
                ));
                $this->view->generateErrorFrameException($ex);
            }
        }
    
    
        /**
         * Return the instance of Module which has been autoloaded
         *
         * @param string $name
         * @return object instance of a Module
         */
        public function _module($name)
        {
            if (array_key_exists($name, $this->module_loaded)) {
                return $this->module_loaded[$name];
            } else {
                return ($this->module_loaded[$name] = $this->loadModule($name));
            }
        }
    
        public function _set_module($name, $module)
        {
            //return (isset($this->module_loaded[$name]) ? $this->module_loaded[$name] : NULL );
            $name = ucfirst(strtolower($name));
    
            if (isset($this->module_loaded[$name])) {
                //echo $this->module_loaded[$name];
                $this->module_loaded[$name] = $module;
            } else {
                $ex = new Exception(array(
                    'message' => 'Instance of  Module ' . $name . '. not found  Hint:  may it has not declared to be  autoloaded',
                    'status' => 404
                ));
                $this->view->generateErrorFrameException($ex);
            }
        }
    
        /**
         * Return an instance of a manager which has been autoloaded 
         * if the manager is not loaded it will load it.
         *
         * @param type $name
         * @return type
         */
        public function _manager($name)
        {

            //return (isset($this->manager_loaded[$name]) ? $this->module_loaded[$name] : NULL );
            $name = ucfirst(strtolower($name));
            if (isset($this->manager_loaded[$name])) {
                return $this->manager_loaded[$name];
            } else{
                return ($this->manager_loaded[$name] = $this->loadManager($name));
            }
        }
    
        public function _set_manager($name, $menager)
        {
            //return (isset($this->manager_loaded[$name]) ? $this->module_loaded[$name] : NULL );
            $name = ucfirst(strtolower($name));
            if (isset($this->manager_loaded[$name])) {
                $this->manager_loaded[$name] = $menager;
            } else {
                $ex = new Exception(array(
                    'message' => 'Instance of  manager ' . $name . '. not found  Hint:  may it has not declared to be  autoloaded',
                    'status' => 404
                ));
                $this->view->generateErrorFrameException($ex);
            }
        }
    
        /**
         * Return an instance of a class which has been autoloaded or it will load it (if it is not in the autoload file)
         *
         * @param type $name
         * @return type
         */
        public function _class($name)
        {
            //return (isset($this->class_loaded[$name]) ? $this->module_loaded[$name] : NULL );
            $name = ucfirst(strtolower($name));
            if (isset($this->class_loaded[$name])) {
                return $this->class_loaded[$name];
            } else{
                return ($this->class_loaded[$name] = $this->loadClass($name));
            } 
        }
    
        public function _set_class($name, $class)
        {
            $name = ucfirst(strtolower($name));
            if (isset($this->class_loaded[$name])) {
    
                $this->class_loaded[$name] = $class;
            } else {
                $ex = new Exception(array(
                    'message' => 'Instance of class ' . $name . '. not found  Hint:  may it has not declared to be  autoloaded',
                    'status' => 404
                ));
                $this->view->generateErrorFrameException($ex);
            }
        }
    
        /**
         * Return an instance of a entity which has been autoloaded [same as the other]
         *
         * @param type $name
         * @return type
         */
        public function _entity($name)
        {
            //return (isset($this->entity_loaded[$name]) ? $this->module_loaded[$name] : NULL );
            $name = ucfirst(strtolower($name));
            if (isset($this->entity_loaded[$name])) {
                return $this->entity_loaded[$name];
            }else{
                return ($this->entity_loaded[$name] = $this->loadEntity($name));
            }
        }
    
        public function _set_entity($name, $entity)
        {
            $name = ucfirst(strtolower($name));
            if (isset($this->entity_loaded[$name])) {
                $this->entity_loaded[$name] = $entity;
            } else {
                $ex = new Exception(array(
                    'message' => 'Instance of entity ' . $name . '. not found  Hint:  may it has not declared to be  autoloaded',
                    'status' => 404
                ));
                $this->view->generateErrorFrameException($ex);
            }
        }
    
    
        public function ressources($bundle, $res, $data = NULL)
        {
            $path = './src/Bundle' . ucfirst(strtolower($bundle)) . '/view/' . $res . '.php';
            if (file_exists($path)) {
                require_once $path;
            } else {
                $ex = new Exception(array(
                    'message' => 'Impossible de trouver la ressources [' . $res . '] du bundle [' . $bundle . ']',
                    'status' => 404
                ));
                $this->view->generateErrorFrameException($ex);
            }
        }
    
        public function includ($bundle, $res, $data = NULL)
        {
            ob_start();
            $this->ressources($bundle, $res, $data);
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
        public function redirect($bundle, $controller, $method = NULL, $args = NULL)
        {
            $addr = 'location:http://' . APP . '/' . $bundle . '/' . $controller;
            if ($method != NULL) {
                $addr .= '/' . $method;
            }
    
            if ($args != NULL) {
                $a = "";
                //foreach ($args as $arg->$val){
                //  $a =
                //}
                $addr .= '/?' . $args;
            }
    
            //start the redirection here
            header($addr);
        }
    }
     