<?php

  namespace core\FrameRouter;

//les inclusion ici
  require_once 'FrameException.php';

  //les use unregister_tick_function
  use core\FrameException;
  /**
   * Cette classe represente le router du site
   *
   * FONCTIONNEMENT
   * a l'entree d'une requete on verifie s'il existe un controlleur isControlleur(); puis une methodes
   * isMethode(); ensuite si le controlleur existe on verifie s'il a la methode demander avec method_exists();
   * si oui on la lance invoke(); avec la reflexivité sinon on va emettre une exception FrameException;
   *@author simoadonis@gmail.com
   */
  class FrameRouter
  {

    function __construct(argument)
    {
      # code...
    }
  }



 ?>
