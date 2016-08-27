<?php

    class ControlleurDefault extends \Frame\Core\Controller
    {

        public function __construct($argument = null)
        {
            parent::__construct($argument);
        }

        public function indexAction()
        {
            echo 'Je suis le controlleur par defaut  de BundleDefault et je fonctionne';
        }

    }