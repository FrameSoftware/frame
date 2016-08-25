<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Configurator class permit the user to acces XML , or JSON documennt
 *
 * @author adonis_97
 */
class Configurator {
    
    /**
     *  
     * Hold the name of the current configuration file
     * @var type string
     */
    private $file;
    
    /**
     * Hold the path to the current configuration file
     * 
     * @var type string
     */
    private $file_path;
    
    /**
     * return a XML objet data structure which has the same structure as the $file_path
     * internal structure. This class will use 
     * 
     * @param type $file_path
     */
    public function loardXmlConfig($file_path){
        
    }
    
    /**
     * Lord an JSON object which contain the structure of file_path in json
     * 
     * @param type $file_path
     */
    public function loardJsonConfig($file_path){
        
    }
    
}
