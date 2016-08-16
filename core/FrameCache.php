<?php

namespace core\FrameCache;

/**
 * Cette classe est responsable du caching dans le framework
 * elle va disposer d'une methode is_cached($hash) elle prend en parametre
 * un hash generer avec MD5 et comparer avec sa base de hash pour savoir
 * si lma resseource est deja dans la memoire. le cache va simplement 
 * creer un fichier sans extension qui contient les données en cache
 *
 * @author SIMO
 */
class FrameCache {
    
    private $cache_dir;
    private $cache_list;
    private $hash;


    public function __construct() {
        $this->cache_dir = './var/cache/';
        //on reseigne le chemin d'access des données dans le cache
    }
    
    public function is_cached($hash){
        
    }
    
    public function addToCache($data){
        echo 'ajouter';
    }
    
    public function getFromCache($name){
        $hash = md5($name);
        if(!$this->is_cached($hash==true)){
            //prevoir le code pour gerer le cas ou
            // les data ne sont pas dispo en cache 
        }
    }
}
