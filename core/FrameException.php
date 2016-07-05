<?php

  namespace core\FrameException;

  /**
   * Cette classe va permettre de gerer les exceptions dans le framework
   *@author simoadonis@gmail.com
   */
  class FrameException extends ErrorException
  {

    private $message;
    private (int) $code;
    private $status

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

    function __construct($argument= array())
    {
      this->hydrate($argument);
      //on
    }

    private function hydrate($arg=array()){
      if(isset($arg['message'])){
        $this->setMessage($arg['message'])
      }

      if(isset($arg['code'])){
        $this->setMessage($arg['code'])
      }

      if(isset($arg['status'])){
        $this->setMessage($arg['status'])
      }
    }

    function message(){
      //retourne le message de l'exception
      return $this->message;
    }

    function code(){
      //retourne le message de l'exception
      return (int) $this->code;
    }

    function status(){
      //retourne le message de l'exception
      return $this->statusf;
    }

    function setMessage($msg){
      $this->message = $msg;
    }

    function setCode((int) code ){
      $this->code = code;
    }

    function setStatus($status){
      $this->status = $status;
    }
  }
