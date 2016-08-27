<?php

namespace Frame\Core;

//require_once 'FrameRouter.php';
//require_once 'FrameHTTPQuery.php';
//require_once 'FrameHTTPResponse.php';
//require_once 'FrameException.php';
//require_once 'FrameView.php';

//use core\FrameHTTPQuery as FHTTPQuery;
//use core\FrameHTTPResponse as FHTTPResponse;
//use core\FrameException as FException;
//use core\FrameRouter as FRouter;
//use core\FrameView as FViewEngine;


/**
 * Le kernel qui permet de gerer toutes les requete et les controls a tout les niveau
 */
class FrameKernel
{

    private $current_exception;
    private $http_query;
    private $http_response;
    private $bundleName;
    private $bundle;
    private $acl = array();
    private $bundle_list = array();
    private $controller_list = array();
    private $method_list = array();


    public function __construct()
    {
        $this->http_query = new FrameHTTPQuery();
        $this->http_response = new FrameHTTPResponse();
    }

    /**
     * Cette methode est appele dans index.php pour lance le kernel
     * elle a pour role d'effectuer le controle de l'url et des autres
     * information
     */
    public function launch_kernel()
    {
        $router = new FrameRouter();
        $response = $router->route_url();
        $this->http_response = $response;

        require_once $response->getControllerPath();
        //reflexivité
        $reflect_controlleur = new \ReflectionMethod($response->getControllerClass(), $response->getMethodeName());


        $controlleur = $response->getControllerClass();
        $controlleur = new $controlleur;//on instancie le controlleur
        //$this->control_user();

        if ($reflect_controlleur->getParameters()) {//si la methode prend des parametres on lance avec GET

            $reflect_controlleur->invoke($controlleur, $_GET);
        } else {//sinon
            $reflect_controlleur->invoke($controlleur);

        }
    }

    /**
     * This methode will be use to control the route which is take by and user throught and XML file
     *
     * @param \core\FrameHTTPResponse\FrameHTTPResponse $response
     */
    public function control_user()
    {
        //session_start();
        $addr = './src/Config/acl_config.xml';
        if ($xml_rule = simplexml_load_file($addr)) {
            //on commence par cree  les tableau des requetes

            //la liste des ACL
            foreach ($xml_rule->level as $lv):
                $this->acl[] = $lv['access'];
                //echo $xml_rule->level->route['bundle'];
            endforeach;//we has take all the access level which is defined

            if (!in_array($_SESSION['acl'], $this->acl)) {//if the acl of user exist in the XML file
                //prevoir le code pour annuler
            }
            $acll = $_SESSION['acl'];


            $bundle = $this->http_response->getBundleName();
            echo $bundle . '<br/>';
            $controller = $this->http_response->getControllerClass();
            echo $controller . '<br/>';
            $methode = $this->http_response->getMethodeName();
            echo $methode . '<br/>';
            $user_route = $this->http_response->getBundleName() . $this->http_response->getControllerClass() . $this->http_response->getMethodeName();

            //on initialise toutes les liste par rapport a un ACL pour le control ulterieur
            foreach ($xml_rule->level->route as $route):
                $this->bundle_list[] = $route['bundle'];
                echo $route['bundle'] . '<br/>';
                $this->controller_list[] = $route['controller'];
                echo $route['controller'] . '<br/>';
                $this->method_list[] = $route['method'];
                echo $route['method'] . '<br/>';

                $rout_array[] = $route['bundle'] . $route['controller'] . $route['method'];
            endforeach;//we has take all the access level which is defined
            echo '-------------------------<br/>';

            foreach ($rout_array as $r):
                if ($r == $user_route) {

                }
            endforeach;
//            if(in_array($bundle, $this->bundle_list)){
//                if(in_array($controller, $this->controller_list)){
//                    if(in_array($methode, $this->method_list)){
//                        //si le chemin existe bel et bien
//                        $require_state = $route[$bundle][$controller][$methode]['auth']?$route[$bundle][$controller][$methode]['auth']:false;
//                        echo $require_state;
//                        return;
//                    }
//                }
//            }
//            //on verifie les parametres de la reponse (si il sont dans les listes
//            
//            //$bundlename = $this->acl[$_SESSION['acl']]->route['bundle'];
//           // $controller = $this->acl[$_SESSION['acl']]->route['controller'];
//            //$metod = $this->acl[$_SESSION['acl']]->route['method'];
//            $auth = $this->acl[$_SESSION['acl']]->route['auth'] ? $this->acl[$_SESSION['acl']]->route['auth'] : false;
//            
//            if($auth == TRUE && $_SESSION['is_auth'] != true){//if we need to be authentificate and the user is not auth
//                $this->http_response->setStatus(false);
//                $this->http_response->setResponseMessage('Impossible d\'acceder a la route specifier : niveau d\'access non adequat');
//                return;
//            }
//            $this->http_response->setStatus(true);
//            $this->http_response->setResponseMessage('ok');
//            //il est authentifier si neccessaire on verifie maintenant les routes
//            
//            $this->
//            return;
        }
    }
}
