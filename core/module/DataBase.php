<?php

require_once './core/FrameView.php';
require_once './core/FrameException.php';

use core\FrameView as FView;
use core\FrameException as FException;


/**
 * Cette classe va offrire les methode necessaires pour l'acces et l'interrogation des base de donnée
 *
 * @author SIMO
 */
class DataBase {
    private $db;
    private $user;
    private $pass;
    private $host;
    private $port;
    private $dataBase;
    private $db_name;
    
    public function __construct() {
        try{
            $this->init_db();
            $dsn = $this->dataBase.':host='.  $this->host.';dbname='.  $this->db_name;
            $this->db = new \PDO($dsn,  $this->user,  $this->pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (\Exception $ex){//exception non reconnu
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
    
    public function init_db(){
        
        if(!$db_ini_file = parse_ini_file('./src/config/data_base.ini')){
            throw new FException\FrameException(array(
                'message'=>'Erreur lors du chargement du fichier de la base de donnée',
                'code'=>404,
                'status'=>false
            ));
        }
        
        $this->db_name = $db_ini_file['db_name'];
        $this->user = $db_ini_file['user'];
        $this->pass = $db_ini_file['pass'];
        $this->host = $db_ini_file['host'];
        $this->port = $db_ini_file['port'];
        $this->dataBase = $db_ini_file['sgbd'];
    }
    
    public function getDB(){
        return $this->db;
    }
    public function execute_query($query){
        try{
            return $this->getDB()->exec($query);
        }  catch (\PDOException $ex){
            $view = new FView\FrameView();
            $view->generateErrorPDOExceptio($ex);
        }
    }
    
    public function execute_prepare_query($sql,$para = NULL){
        try{
            if($para != NULL){
                $query = $this->getDB()->prepare($sql);
                return $query->execute($para);
            }else{
                return $query = $this->getDB()->exec($sql);
            }
        }  catch (\Exception $ex){//exception non reconnu
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
    
    private function select_query($table){
        
    }
}
