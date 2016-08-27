<?php

    /**
     * Frame - A lightweight PHP framework
     */

    namespace Frame\Core;

    /**
     * Cette classe est responsable du caching dans le framework
     * elle va disposer d'une methode is_cached($hash) elle prend en parametre
     * un hash generer avec MD5 et comparer avec sa base de hash pour savoir
     * si lma resseource est deja dans la memoire. le cache va simplement
     * creer un fichier sans extension qui contient les données en cache
     *
     * @author SIMO
     */
    class Cache
    {

        private $cache_dir;

        public function __construct()
        {
            $this->cache_dir = FRAME_ROOT_PATH . '/var/cache';
            if (!file_exists($this->cache_dir) && !@mkdir($this->cache_dir, 0777, TRUE) && !is_dir($this->cache_dir)) {
                throw new Exception(array(
                    'message' => "Internal error occurred. Can't create the required directory at path \"{$this->cache_dir}\", maybe you don't have write access.",
                    'status'  => 500
                ));
            }
        }

        public function is_cached($name)
        {
            return file_exists($this->_getCachePath($name));
        }

        public function addToCache($name, $data)
        {
            file_put_contents($this->_getCachePath($name), $data);
        }

        public function getFromCache($name)
        {
            if (!$this->is_cached($name)) {
                return file_get_contents($this->_getCachePath($name));
            }
            return FALSE;
        }

        private function _getCachePath($name)
        {
            return $this->cache_dir . '/' . md5($name);
        }
    }
