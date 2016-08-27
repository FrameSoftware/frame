<?php

    namespace Frame\Core;

    //les inclusion ici
    //  require_once 'FrameException.php';
    //  require_once 'FrameHTTPQuery.php';
    //  require_once 'FrameHTTPResponse.php';
    //  require_once 'FrameView.php';

        //les use unregister_tick_function
    //  use core\FrameException as FException;
    //  use core\FrameHTTPQuery as FHTTPQuery;
    //    use core\FrameHTTPResponse as FHTTPResponse;
    //  use core\FrameView as FViewEngine;
    /**
     * Cette classe represente le router du site
     *
     * FONCTIONNEMENT
     * a l'entree d'une requete on verifie s'il existe un controlleur isControlleur(); puis une methodes
     * isMethode(); ensuite si le controlleur existe on verifie s'il a la methode demander avec method_exists();
     * si oui on la lance invoke(); avec la reflexivité sinon on va emettre une exception FrameException;
     * @author simoadonis@gmail.com
     */
    class FrameRouter
    {
        private $controlleur_class;
        private $controlleur_path;
        private $method_name;
        private $default_controlleur;
        private $default_method;
        private $bundle_name;
        private $bundle_path;
        private $bundle_default;
        /*
         * Le chemin de la ressource a executer
         */
        private $total_path;


        public function __construct()
        {
            //a pour role de charge la configuration
            $config = Controller::getInstance()->_module('Configuration')->loadConfig('router.ini');
            $this->default_controlleur = ucfirst(strtolower($config['default_controller']));
            $this->default_method = $config['default_method'];
            $this->bundle_default = $config['default_bundle'];
        }


        /*
         * prend la requete http en paramettre et retourne la reponse
         */
        public function route_url()
        {
            // Fusion des paramètres GET et POST de la requête
            $requete = new FrameHTTPQuery();
            //prevoir la gestion des Module(bundle)
            //on initialise les parametres de la requete ici
            $this->getBundle($requete);//on cree le Module ici
            $this->getControlleur($requete);//on cree le controlleur ici
            $this->getMethod($requete);//on cree la methode ici
            $response = new FrameHTTPResponse($data = array(
                'bundle_name' => $this->bundle_name,
                'bundle_path' => $this->bundle_path,
                'controller_class' => $this->controlleur_class,
                'controller_path' => $this->controlleur_path,
                'method_name' => $this->method_name
            )); //on retourne la reponse ici

            return $response;
        }

        public function getResponse()
        {//va retourne la reponse du router
            //return FHTTPResponse\FrameHTTPResponse $response;
        }

        public function getBundle(FrameHTTPQuery $query)
        {
            $defaultBundle = ucfirst(strtolower(trim($this->bundle_default))); //on recupere le bundle par defaut
            if ($query->getExist('b')) {
                $defaultBundle = ucfirst(strtolower(trim($query->get('b'))));
                //on met le nom en minuscule et on verifie avec les rReGexS
            }//la creation du bundle est finit

            //creation du nom du bundle
            $bundleNom = 'Bundle' . $defaultBundle;
            $bundlePath = 'src/Bundle' . $defaultBundle; //le chemin d'acces
            if (is_dir($bundlePath)) {
                //on stocke les données par rapport au conrolleur
                $this->bundle_name = $bundleNom;
                $this->bundle_path = $bundlePath;
            } else {
                throw new Exception(array(
                    'message' => "impossible de trouver le bundle '$bundleNom' ",
                    'code' => 441,
                    'fichier' => __FILE__,
                    'ligne' => __LINE__
                ));
            }
        }

        /*
         * A pour role d'initialiser le controlleur :
         * si ce n'est pas definie on affecter le controlleur par defaut Authentification
         * ce qui devra estre changer pour etre stocker dans le fichier de configutation
         * l'exception FrameException est lancer si le fichier du controlleur n'est pas trouver
         */
        public function getControlleur(FrameHTTPQuery $query)
        {
            $defaultController = $this->default_controlleur;
            if ($query->getExist('c')) {
                $defaultController = trim($query->get('c'));
                $defaultController = ucfirst(strtolower(trim($defaultController)));
                //on met le nom en minuscule et on verifie avec les rReGexS
            }//la creation du controlleur est finit

            //creation du nom du controlleur
            $classeControlleur = 'Controlleur' . $defaultController;
            $fichierControlleur = $this->bundle_path . '/controller/' . $classeControlleur . '.php'; //le chemin d'acces
            if (file_exists($fichierControlleur)) {
                //on stocke les données par rapport au conrolleur
                $this->controlleur_class = $classeControlleur;

                $this->controlleur_path = $fichierControlleur;

            } else {
                throw new Exception(array(
                    'message' => "impossible de trouver le controlleur '$classeControlleur' dans le bundle '$this->bundle_name' ",
                    'code' => 444,
                    'fichier' => __FILE__,
                    'ligne' => __LINE__
                ));
            }
        }

        /*
        * retourne si sa existe la methode d'une requete
        */
        public function getMethod(FrameHTTPQuery $query)
        {
            $defaultMethod = $this->default_method;
            if ($query->getExist('m')) {
                $this->method_name = $query->get('m') . 'Action'; //on recupere l'action
            } else {
                $this->method_name = $defaultMethod;
            }
        }
    }
