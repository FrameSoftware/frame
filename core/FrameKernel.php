<?php

namespace core\FrameKernel;

require_once 'FrameRouter.php';
require_once 'FrameHTTPQuery.php';
require_once 'FrameHTTPResponse.php';
require_once 'FrameException.php';
require_once 'FrameView.php';

use core\FrameException as FException;
use core\FrameHTTPQuery as FHTTPQuery;
use core\FrameHTTPResponse as FHTTPResponse;
use core\FrameRouter as FRouter;
use core\FrameView as FViewEngine;




/**
 * Le kernel qui permet de gerer toutes les requete et les controls a tout les niveau
 */
class FrameKernel {
    
    private $current_exception;
    private $http_query;
    private $http_response;
    private $bundleName;
    private $bundle;
   

    /**
     * Cette methode est appele dans index.php pour lance le kernel
     * elle a pour role d'effectuer le controle de l'url et des autres
     * information
     */
    public function launch_kernel(){
        try {
            // Fusion des paramètres GET et POST de la requête
            $requete = new FHTTPQuery\FrameHTTPQuery(array_merge($_GET, $_POST));
            $response = new FHTTPResponse\FrameHTTPResponse();
            $router = new FRouter\FrameRouter();
            $response =  $router->route_url();
            require_once $response->getControllerPath();
            $reflect_controlleur = new \ReflectionMethod($response->getControllerClass(), $response->getMethodeName());
            $controlleur =  $response->getControllerClass();
            $controlleur = new $controlleur;//on instancie le controlleur
            if($reflect_controlleur->getParameters()){//si la methode prend des parametres on lance avec GET
                 $reflect_controlleur->invoke($controlleur, $_GET);
            }else{//sinon
                 $reflect_controlleur->invoke($controlleur);
            }
          }catch(FException\FrameException $ex) {
           //On doit appeler le moteur de vue pour afficher le message d'erreur ici
            $view= new FViewEngine\FrameView();
            $view->generateErrorFrameException($ex);
          }catch(\ReflectionException $rex){
              $view= new FViewEngine\FrameView();
              $view->generateErrorReflectionException($rex);
          }
    }
}
