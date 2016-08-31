<?php

    /**
     * Frame - A lightweight PHP framework
     */

    namespace Frame\Core;

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
            $this->getBundle();//on cree le Module ici
            $this->getControlleur();//on cree le controlleur ici
            $this->getMethod();//on cree la methode ici
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

        public function getBundle()
        {
            $defaultBundle = $this->bundle_default;

            $base_url = parse_url(Controller::getInstance()->loadModule('Configuration')->loadConfig('app.ini')['app_uri']);
            $this_url = parse_url($_SERVER['REQUEST_URI']);

            $this_bundle = explode('/', str_replace($base_url['path'], '', $this_url['path']))[0];

            $bundle = ucfirst(strtolower(trim($this_bundle === '' ? $defaultBundle : $this_bundle)));

            //creation du nom du bundle
            $bundleNom = 'Bundle' . ucfirst(strtolower(trim($bundle)));
            $bundlePath = FRAME_SRC_PATH . '/' . $bundleNom; //le chemin d'acces
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
        public function getControlleur()
        {
            $defaultController = $this->default_controlleur;

            $base_url = parse_url(Controller::getInstance()->loadModule('Configuration')->loadConfig('app.ini')['app_uri']);
            $this_url = parse_url($_SERVER['REQUEST_URI']);

            $this_controller = explode('/', str_replace($base_url['path'], '', $this_url['path']));
            $this_controller = (array_key_exists(1, $this_controller)) ? $this_controller[1] : '';

            $controller = $this_controller === '' ? $defaultController : $this_controller;

            //creation du nom du controlleur
            $classeControlleur = 'Controlleur' . ucfirst(strtolower(trim($controller)));
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
        public function getMethod()
        {
            $defaultMethod = $this->default_method;

            $base_url = parse_url(Controller::getInstance()->loadModule('Configuration')->loadConfig('app.ini')['app_uri']);
            $this_url = parse_url($_SERVER['REQUEST_URI']);

            $this_method = explode('/', str_replace($base_url['path'], '', $this_url['path']));
            $this_method = (array_key_exists(2, $this_method)) ? $this_method[2] : '';

            $method = $this_method === '' ? $defaultMethod : $this_method;

            $this->method_name = $method . 'Action';
        }
    }
