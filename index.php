<?php
session_start();
$_SESSION['auth'] = true;
$_SESSION['acl'] = 'visitor';
require_once 'core/FrameRouter.php';
require_once 'core/FrameKernel.php';

//use core\FrameRouter as FRouter;

use core\FrameKernel as FKernel;

//$router = new FRouter\FrameRouter();
//$router->route_url();
if(isset($_SESSION['auth'])){
    $kernel = new FKernel\FrameKernel();
    $kernel->launch_kernel();
}else{
    echo 'not logged';
}