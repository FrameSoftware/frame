<?php

    namespace Frame\Core;

    /**
     * Cette classe est represente une URL qui entre dans le routeur et possede les methodes
     * pour son interogation
     * @author simoadonis@gmail.com
     */
    class FrameHTTPQuery
    {

        public function get_Exist($name){

            if (array_key_exists($name, $_GET) ) {
                return true;
            } else {
                return false;
            }
        }

        public function getParam($name){
            if ($this->get_Exist($name)) {
                return $_GET[$name];
            } else {
                throw new Exception(array(
                    'message' => "Le parametre '{$name}' n'exite pas",
                    'code' => 404
                ));
            }
        }

        public function post_Exist($name)
        {
            if (array_key_exists($name, $_POST)) {
                return true;
            } else {
                return false;
            }
        }

        public function postPram($name)
        {
            if ($this->post_Exist($name)) {
                return $_POST[$name];
            } else {
                throw new Exception(array(
                    'message' => "Le parametre '{$name}' n'exite pas",
                    'code' => 404
                ));
            }
        }


        public function postExist($name)
        {
            if (array_key_exists($name, $_POST) && $_POST[$name] != "") {
                return true;
            } else {
                return false;
            }
        }

        public function getExist($name)
        {
            if (array_key_exists($name, $_GET) && $_GET[$name]  != "") {
                return true;
            } else {
                return false;
            }
        }

        public function fileExist($name)
        {
            if (array_key_exists($name, $_FILES)) {
                return true;
            } else {
                return false;
            }
        }

        public function post($name)
        {
            if ($this->postExist($name)) {
                return $_POST[$name];
            } else {
                throw new Exception(array(
                    'message' => "Le parametre '{$name}' n'exite pas",
                    'code' => 404
                ));
            }
        }

        public function get($name)
        {
            if ($this->getExist($name)) {
                return $_GET[$name];
            } else {
                throw new Exception(array(
                    'message' => "Le parametre '{$name}' n'exite pas",
                    'code' => 404
                ));
            }
        }

        public function file($name)
        {
            if ($this->fileExist($name)) {
                return $_FILES[$name];
            } else {
                throw new Exception(array(
                    'message' => "Le parametre '{$name}' n'exite pas",
                    'code' => 404
                ));
            }
        }
    }
