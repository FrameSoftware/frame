<?php
namespace core\FrameLogger;

/**
 * FrameLogger est chargé d'effectuer le loggin dans tout le framwork
 *
 * @author SIMO
 */
class FrameLogger {
    
    private $data;
    private $log_dir;
    private  $log_dir_error;
    private $log_dir_warn;
    private $log_warn;
    private $log_err;


    public function __construct(){
        $this->log_dir = './var/log';
        $this->log_dir_error = './var/log/error.log';
        $this->log_dir_warn = './var/log/warning.log';
        
        $this->log_warn = file($this->log_dir_warn);
        $this->log_err = file($this->log_dir_error);
    }
    
    public function log($level,$data){
        if($level == 'ERROR'){
            
        }
        
        if($level == 'WARNING'){
            
        }
        
        if($level != 'ERROR' && $level != 'WARNING'){
            
        }
    }
}
