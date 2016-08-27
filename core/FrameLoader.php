<?php

    /**
     * Frame - A lightweight PHP framework
     */

    // -------------------------
    // Frame version
    // -------------------------
    define ( 'FAME_VERSION' , '1.0.0' );

    // -------------------------
    // Loading user session
    // -------------------------
    session_start();

    // -------------------------
    // Loading required files
    // -------------------------
    require __DIR__ . '/FrameCache.php';
    require __DIR__ . '/FrameController.php';
    require __DIR__ . '/FrameDataBase.php';
    require __DIR__ . '/FrameException.php';
    require __DIR__ . '/FrameHTTPQuery.php';
    require __DIR__ . '/FrameHTTPResponse.php';
    require __DIR__ . '/FrameKernel.php';
    require __DIR__ . '/FrameLogger.php';
    require __DIR__ . '/FrameModel.php';
    require __DIR__ . '/FrameRedirection.php';
    require __DIR__ . '/FrameRouter.php';
    require __DIR__ . '/FrameView.php';
