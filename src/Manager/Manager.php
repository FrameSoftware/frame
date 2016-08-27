<?php

require_once './core/FrameDataBase.php';

use core\FrameDataBase\FrameDataBase as FrameDataBase;

/**
 * Description of Manager
 * This class is the upper class for all the manager of the application 
 * It contains method which is usable by all the manager such as :
 * create , delete , update , read (CRUD) , 
 *
 * @author adonis_97
 */
class Manager extends FrameDataBase {
    //put your code here
    protected $table_name;
    protected $id_name;




    public function __construct($table = NULL) {
        parent::__construct();
        if($table != NULL){
            $this->table_name = $table;
        }
    }
    
    /**
     * Return the class which is passed as argument
     * @param type $entity
     */
    public function loadEntity($entity , $data = NULL){
        $entity = ucfirst(strtolower($entity));
        
        $this->entity = './src/Entity/'.$entity.'Entity.php';
        if(file_exists($this->entity)){
            require_once $this->entity;
            $entity_class = $entity.'Entity';
            if($data == NULL){
                return new $entity_class();
            }else{
                return new $entity_class($data);
            }
            
        }else{
            $ex =  new FException\FrameException(array(
                'message'=>'Unable to find the specified entity',
                'status'=>404
            ));
            $this->view->generateErrorFrameException($ex);
        }
    }

    public function getIdName(){
        return $this->id_name;
    }
    
    public function setIdName($id_name){
        $this->id_name = $id_name;
    }

    public function getTableName(){
        return $this->table_name;
    }
    
    public function setTableName($tab_name){
        $this->table_name = $tab_name;
    }
    
    /**
     * This method is user by all the manager to select all data in a table
     * it is the Create part of CRUD
     */
    public function selectAll(){
        $sql = "select * from ".$this->table_name;
        return $this->execute_query($sql)->fetchAll();
    }
    
    public function selectById($value){
        $sql = "select * from ".$this->table_name." where ".$this->id_name." =  :id";
        $param = array(
            ":id"=>$value
        );
        return $this->execute_query($sql, $param)->fetchAll();
    }
    private function insert($entity){
        $sql = "insert into ".$this->table_name."()";
    }
}
