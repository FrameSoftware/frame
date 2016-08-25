<?php
session_start();

require_once 'core/FrameRouter.php';
require_once 'core/FrameKernel.php';

//use core\FrameRouter as FRouter;

use core\FrameKernel as FKernel;

define('APP', 'localhost/frame');
//$router = new FRouter\FrameRouter();
//$router->route_url();
    $kernel = new FKernel\FrameKernel();
    $kernel->launch_kernel();
