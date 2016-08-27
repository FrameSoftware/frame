<?php

    namespace Frame\Core;

    /**
     * Cette classe est represente une URL qui entre dans le routeur et possede les methodes
     * pour son interogation
     * @author simoadonis@gmail.com
     */
    class FrameHTTPQuery
    {
        public function postExist($name)
        {
            if (array_key_exists($name, $_POST)) {
                return true;
            } else {
                return false;
            }
        }

        public function getExist($name)
        {
            if (array_key_exists($name, $_GET)) {
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
