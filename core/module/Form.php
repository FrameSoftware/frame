<?php

//namespace core\module;

require_once 'field.php';

//use core\module\Field as CField;
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
    private $field;

    public function __construct($nom = NULL) {
        $this->nom = $nom;
        $this->hash = md5($nom);
        $this->field = new Field();
    }
    
    public function open($action = null,$method = null){
        echo "<form action='$action' method='$method' >\n";
        $this->add_output("<form action='$action' method='$method' >\n");
    }
    
    public function close(){
        echo "</form>";
        $this->add_output("</form>");
    }
    
    private function add_output($txt){
        $this->input_txt_list =$this->input_txt_list. $txt;
    }
    
    /**
     * Cette fonction est concu pour afficher les elements 
     * du formulaire
     * @param type $field
     */
    public function add_field($field = array()){
        $this->field->hydrate($field);
        $this->addField($this->field);
        return $this;
    }
    
    public function add_fieldln($field = array()){
        $this->field->hydrate($field);
        $this->addField($this->field,true);
        return $this;
    }
    
    private function addField(Field $field,$state = null){
        $ln = '';
        if($state == true){
            $ln = '<br/>';
        }
        $input =  $field->getLabel()."<input type='".$field->getType()."' name='".
                $field->getName() ."' class='".
                $field->getClass() ."' id='".
                $field->getId()."' value='".
                $field->getValue()."' />".$ln."\n";
        $this->add_output($input);
        echo $input;
        $this->field_list[] = $field;
        //return $this;
        $field->clean();
    }
    
    
    
    function getHash() {
        return md5($this->nom);
    }
    
 
    function getNom() {
        return $this->nom;
    }

    function getField_list() {
        return $this->field_list;
    }

//    function setHash( $hash) {
//        $this->hash = $hash;
//    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setField_list($field_list) {
        $this->field_list = $field_list;
    }
    
    function output(){
        return $this->input_txt_list;
    }

}
