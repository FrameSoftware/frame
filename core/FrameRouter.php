<?php

  namespace core\FrameRouter;

//les inclusion ici
  require_once 'FrameException.php';
  require_once 'FrameHTTPQuery.php';
  require_once 'FrameView.php';

  //les use unregister_tick_function
  use core\FrameException as FException;
  use core\FrameHTTPQuery as FHTTPQuery;
  use core\FrameView as FViewEngine;
  /**
   * Cette classe represente le router du site
   *
   * FONCTIONNEMENT
   * a l'entree d'une requete on verifie s'il existe un controlleur isControlleur(); puis une methodes
   * isMethode(); ensuite si le controlleur existe on verifie s'il a la methode demander avec method_exists();
   * si oui on la lance invoke(); avec la reflexivité sinon on va emettre une exception FrameException;
   *@author simoadonis@gmail.com
   */
  class FrameRouter
  {
      private $controlleur_class;
      private $controlleur_path;
      private $method_name;
      private $default_controlleur;
      private $default_method;


      public function __construct() {
          //a pour role de charge la configuration 
          try {
                  $config = parse_ini_file('routerConfig.ini');
                  $this->default_method = $config['default_method'];
              }else{
                  throw new FException\FrameException(array(
                  'message'=>"impossible de charger le fichier de configuration des controlleurs et methodes",
                  'code'=> 401,
                  'fichier'=>__FILE__
                ));
              }
              
          } catch (FException\FrameException $ex) {
              $view= new FViewEngine\FrameView();
              $view->generateErrorFrameException($ex);
          }
      }


      /*
       * prend la requete http en paramettre et effectue le routage
       */
      public function route_url(){
          try {
            // Fusion des paramètres GET et POST de la requête
            $requete = new FHTTPQuery\FrameFrameHTTPQuery(array_merge($_GET, $_POST));
            
            //on initialise les parametres de la requete ici
            $this->getControlleur($requete);
            $this->getMethod($requete);
            require_once $this->controlleur_path;//on charge le controlleur ici avant la refelexivité
            //on va commencer la reflexivité ici
            $reflect_controlleur = new \ReflectionMethod($this->controlleur_class, $this->method_name);
            $controlleur = new $this->controlleur_class;//on instancie le controlleur
            if($reflect_controlleur->getParameters()){//si la methode prend des parametres on lance avec GET
                 $reflect_controlleur->invoke($controlleur, $_GET);
            }else{//sinon
                 $reflect_controlleur->invoke($controlleur);
            }
          }
          catch (FException\FrameException $ex) {
           //On doit appeler le moteur de vue pour afficher le message d'erreur ici
            $view= new FViewEngine\FrameView();
            $view->generateErrorFrameException($ex);
          }

      }
      /*
       * A pour role d'initialiser le controlleur :
       * si ce n'est pas definie on affecter le controlleur par defaut Authentification
       * ce qui devra estre changer pour etre stocker dans le fichier de configutation
       * l'exception FrameException est lancer si le fichier du controlleur n'est pas trouver
       */
      public function getControlleur(FHTTPQuery\FrameFrameHTTPQuery $query){
          $defaultController = $this->default_controlleur;
          if($query->existParam('c')){
              $defaultController = $query->getParam('c');
              $defaultController = ucfirst(strtolower($defaultController));
              //on met le nom en minuscule
          }//la creation du controlleur est finit
          
          //creation du nom du controlleur
          $classeControlleur = 'Controlleur'.$defaultController;
          $fichierControlleur = 'Controlleur/'.$classeControlleur.'.php'; //le chemin d'acces
          if(file_exists($fichierControlleur)){
             //on stocke les données par rapport au conrolleur
             $this->controlleur_class = $classeControlleur;
             $this->controlleur_path = $fichierControlleur;
          }else{
              throw new FException\FrameException(array(
                  'message'=>"impossible de trouver le controlleur '$classeControlleur' ",
                  'code'=> 444,
                  'fichier'=>__FILE__
              ));
          }
      }
      
      /*
       * retourne si sa existe la methode d'une requete
       */
      public function getMethod(FHTTPQuery\FrameFrameHTTPQuery $query){
          $defaultMethod = $this->default_method;
          if($query->existParam('m')){
              $this->method_name = $query->getParam('c'); //on recupere l'action
          }else{
              $this->method_name = $defaultMethod;
          }
      }
  }
