<?php

namespace core\FrameDataBase;

//require_once 'FrameView.php';
//require_once 'FrameException.php';

use core\FrameView as FView;
use core\FrameException as FException;


/**
 * This class will offer an interface to manage databases just as and simple 
 * ORM
 *
 * @author SIMO
 */
class FrameDataBase {
    private $db;
    private $user;
    private $pass;
    private $host;
    private $port;
    private $sgbd;
    private $db_name;
    
    public function __construct() {
        $this->init_db();
        $dsn = $this->sgbd.':host='.  $this->host.';dbname='.$this->dataBase;
        
        $this->db = new \PDO($dsn,  $this->user,  $this->pass,array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
    }
    
    public function init_db(){
        
        if(!$db_ini_file = parse_ini_file('./src/config/data_base.ini')){
            throw new FException\FrameException(array(
                'message'=>'Erreur lors du chargement du fichier de la base de donnée',
                'code'=>404,
                'status'=>false
            ));
        }
        $this->user = $db_ini_file['user'];
        $this->pass = $db_ini_file['pass'];
        $this->host = $db_ini_file['host'];
        $this->port = $db_ini_file['port'];
        $this->dataBase = $db_ini_file['db_name'];
        $this->sgbd = $db_ini_file['sgbd'];
    }
    
    public function getDB(){
        return $this->db;
    }
    
    /*
     * This method is user to execute an sql statement. if it is an prepared query
     * the $query parameter will store the sql query and the $param will contain an
     * array which represent the value who will be use to bind the prepared query
     */
    public function execute_query($query,$param =null){
        try{
            if($param == null){
                return $this->getDB()->exec($query);
            }
            $result = $this->getDB()->prepare($query);
            return $result->execute($param);
        }catch (\Exception $ex){//exception non reconnu
            $view = new FView\FrameView();
            $view->generateErrorException($ex);
        }  catch (FException\FrameException $ex){//exception Frame
            $view = new FView\FrameView();
            $view->generateErrorFrameException($ex);
        }  catch (\PDOException $pdo_ex){//exception PDO
            $view = new FView\FrameView();
            $view->generateErrorPDOExceptio($ex);
        }
    }
    
    /**
     * This methode will be use to select all data field in a table
     * 
     * @param type $table_name
     * @return type
     */
    public function findAll($table_name){
        return $this->execute_query('select * from '.$table_name)->fetchAll();
    }
    
    public function select_query($fields , $from , $where = NULL , $order_by = NULL, $limit = NULL , $group_by = NULL ){
        
    }
    
    private function _from($table){
        
    }
    
    private function _order_by($order){
        
    }
    
    private function _limit($lim_start, $lim_end){
        
    }
    
    private function _where($condition){
        
    }
    
    private function _group_by($group_name){
        
    }
}
