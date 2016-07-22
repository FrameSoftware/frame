<?php

namespace core\module\form;

//require_once 'field.php';

use core\module\field as CField;
/**
 * Cette classe represente les formulaires 
 *
 * @author SIMO
 */
class Form {
    /**
     *Le hash va etre utilise lors de la mise en cache car 
     * les classe de formulaire generent du code
     * @var type 
     */
    private $hash;
    private $nom;
    private $field_list = array();
    private $input_txt_list;

    public function __construct($nom = NULL) {
        $this->nom = $nom;
        $this->hash = md5($nom);
    }
    
    public function open($action = null,$method = null){
        echo "<form action='$action' method='$method' >";
    }
    
    public function close(){
        echo "</form>";
    }
    
    public function addField(CField\Field $field){
        
        $input =  "<input type=".$field->getType()." name=".
                $field->getName() ." class=".
                $field->getClass() ."id=".
                $field->getId()."value=".
                $field->getValue()."/>";
        $this->input_txt_list = $input;
        echo $input;
        $this->field_list[] = $field;
        return $this;
    }
    
    function getHash() {
        return $this->hash;
    }

    function getNom() {
        return $this->nom;
    }

    function getField_list() {
        return $this->field_list;
    }

    function setHash(type $hash) {
        $this->hash = $hash;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setField_list($field_list) {
        $this->field_list = $field_list;
    }


}
