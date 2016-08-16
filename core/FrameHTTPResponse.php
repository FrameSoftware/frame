<?php

namespace core\FrameHTTPResponse;

require_once 'FrameException.php';

use core\FrameException as FException;


class FrameHTTPResponse {
    private $bundleName;
    private $bundlePath;
    
    private $controllerName;
    private $controllerClass;
    private $controllerPath;
    
    private $methodeName;
    
    private $args = array();
    
    private $status = true;
    private $responseMessage;
    
    public function __construct($data = null) {
        $this->hydrate($data);
    }
    
    /**
     * Cette metode permettra d'hydrater les attributs de la classe
     * @param array $data
     */
    public function hydrate($data){
        if(isset($data['bundle_name'])){
            $this->setBundleName($data['bundle_name']);
        }
        
        if(isset($data['bundle_path'])){
            $this->setBundlePath($data['bundle_path']);
        }
        if(isset($data['controller_name'])){
            $this->setControllerName($data['controller_name']);
        }
        if(isset($data['controller_class'])){
            $this->setControllerClass($data['controller_class']);
        }
        if(isset($data['controller_path'])){
            $this->setControllerPath($data['controller_path']);
        }
        
        if(isset($data['method_name'])){
            $this->setMethodeName($data['method_name']);
        }
        
        if(isset($data['args'])){
            $this->setArgs($data['args']);
        }
    }
            
    function getStatus() {
        return $this->status;
    }

    function getResponseMessage() {
        return $this->responseMessage;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setResponseMessage($responseMessage) {
        $this->responseMessage = $responseMessage;
    }
        
    function setBundleName($bundleName) {
        $this->bundleName = $bundleName;
    }

    function setBundlePath($bundlePath) {
        $this->bundlePath = $bundlePath;
    }

    function setControllerName($controllerName) {
        $this->controllerName = $controllerName;
    }

    function setControllerClass($controllerClass) {
        $this->controllerClass = $controllerClass;
    }

    function setControllerPath($controllerPath) {
        $this->controllerPath = $controllerPath;
    }

    function setMethodeName($methodeName) {
        $this->methodeName = $methodeName;
    }

    function setArgs($args) {
        $this->args = $args;
    }
    
    function getBundleName() {
        return $this->bundleName;
    }

    function getBundlePath() {
        return $this->bundlePath;
    }

    function getControllerName() {
        return $this->controllerName;
    }

    function getControllerClass() {
        return $this->controllerClass;
    }

    function getControllerPath() {
        return $this->controllerPath;
    }

    function getMethodeName() {
        return $this->methodeName;
    }

    function getArgs() {
        return $this->args;
    }

}
