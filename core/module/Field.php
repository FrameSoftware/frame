<?php

//namespace core\module\Field;
/**
 * Cette classe represente les champs d'un formulaire
 *
 * @author SIMO
 */
class Field {
    private $type;
    private $name;
    private $value;
    private $label;
    private $id;
    private $class;
    
    public function __construct($param = array()) {
        $this->hydrate($param);
    }
    
    public function clean(){
        $this->setId('');
        $this->setLabel('');
        $this->setName('');
        $this->setType('');
        $this->setClass('');
    }
    
    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
    }

    public function hydrate($param = array()){
       if(isset($param['name'])){
           $this->setName($param['name']);
       }
       
       if(isset($param['type'])){
           $this->setType($param['type']);
       }
       
       if(isset($param['value'])){
           $this->setValue($param['value']);
       }
       
       if(isset($param['id'])){
           $this->setId($param['id']);
       }
       
       if(isset($param['class'])){
           $this->setClass($param['class']);
       }
       
       if(isset($param['label'])){
           $this->setLabel($param['label']);
       }
    }
    
    function getName() {
        return $this->name;
    }

    function getValue() {
        return $this->value;
    }

    function getLabel() {
        return $this->label;
    }

    function getId() {
        return $this->id;
    }

    function getClass() {
        return $this->class;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setValue($value) {
        $this->value = $value;
    }

    function setLabel($label) {
        $this->label = $label;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setClass($class) {
        $this->class = $class;
    }
}
