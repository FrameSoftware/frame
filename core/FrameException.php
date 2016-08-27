<?php

namespace Frame\Core;

  /**
   * Cette classe va permettre de gerer les exceptions dans le framework
   *@author simoadonis@gmail.com
   */
  class Exception extends \ErrorException
  {

    protected $message;
    protected $code;
    protected $status;
    protected $file;
    protected $line;

    public function __toString(){
      switch ($this->severity)  {
      case E_USER_ERROR : // Si l'utilisateur émet une erreurfatale;
        $type = 'Erreur fatale';
        break;
      case E_WARNING : // Si PHP émet une alerte.
      case E_USER_WARNING : // Si l'utilisateur émet une alerte.
        $type = 'Attention';
        break;

      case E_NOTICE : // Si PHP émet une notice.
      case E_USER_NOTICE : // Si l'utilisateur émet une notice.
        $type = 'Note';
        break;

      default : // Erreur inconnue.
          $type = 'Erreur inconnue';
          break;
        }
    }

    function __construct($argument= array())
    {
      $this->hydrate($argument);
      //on
    }

    public function hydrate($arg=array()){
      if(isset($arg['message'])){
        $this->setMessage($arg['message']);
      }

      if(isset($arg['code'])){
        $this->setCode($arg['code']);
      }

      if(isset($arg['status'])){
        $this->setStatus($arg['status']);
      }
      
      if(isset($arg['fichier'])){
        $this->setFichier($arg['fichier']);
      }
      
      if(isset($arg['ligne'])){
        $this->setLine($arg['ligne']);
      }
    }

    function line(){
      //retourne le message de l'exception
      return $this->line;
    }
    
    function message(){
      //retourne le message de l'exception
      return $this->message;
    }

    function code(){
      //retourne le message de l'exception
      return (int) $this->code;
    }
    
    function fichier(){
        $this->file = $file_name;
    }
    
    function setFichier($file_name){
        return $this->file = $file_name;
    }
    
    function setLine($line_num){
        return $this->line = $line_num;
    }

    function status(){
      //retourne le message de l'exception
      return $this->statusf;
    }

    function setMessage($msg){
      $this->message = $msg;
    }

    function setCode( $code ){
      $this->code = $code;
    }

    function setStatus($status){
      $this->status = $status;
    }
  }
