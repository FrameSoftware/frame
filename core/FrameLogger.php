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
        
        $this->log_warn = fopen($this->log_dir_warn,'a+');
        $this->log_err = fopen($this->log_dir_error,'a+');
    }
    
    public function log($level,$data){
        $date =date('d-m-Y');
            $time = date('H-i');
        if($level == 'ERROR'){
            $data = "\n ERROR : ".$date ." ".$time." ".$data." ";
            fputs($this->log_err, $data);
        }
        
        if($level == 'WARNING'){
            
            $data = "\n WARNING : ".$date ." ".$time." ".$data." ";
            fputs($this->log_warn, $data);
        }
        
        if($level != 'ERROR' && $level != 'WARNING'){
            throw new \core\FrameException\FrameException(array(
                'message'=>"niveau de log inconnue",
                'status'=>104
            ));
        }
    }
}
