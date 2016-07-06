<?php

  namespace core\FrameHTTPQuery;

  require_once 'FrameException.php';
  
 
  /**
   * Cette classe est represente une URL qui entre dans le routeur et possede les methodes
   * pour son interogation
   *@author simoadonis@gmail.com
   */
  class FrameFrameHTTPQuery
  {
      /*
       * represente la requet envoye pat le navigateur POST et GET
       */
      private $query;

    public function __construct($argument)
    {
        $this->query = $argument;
    }
    
    /*
     * Pour teste si le parametre existe reelement
     */
    public function existParam($name){
        return (isset($this->query[$name]) && $this->query[$name] != "");
    }
    
    public function getParam($name){
        if($this->existParam($mame)){
            return $this->query[$name];
        }else{
            throw new FrameException(array(
                'message'=>"Le parametre '$name' n'exite pas",
                'code'=>404
            ));
        }
    }
  }
