<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Erreur - Frame 1.0</title>
        <style>
            .container{
                margin-left: auto;
                margin-right: auto;
                width: 80%;
                /*background-color: #ff6666;*/
            }
            
            fieldset{
                border-radius: 5px 5px 5px 5px;
                border-color: #ff6666;
            }
            
            legend{
                border: 1px solid;
                border-radius: 5px 5px 5px 5px;
                color: #ff6666;
                -webkit-box-shadow: 0px 0px 14px -2px rgba(0,0,0,0.75);
                -moz-box-shadow: 0px 0px 14px -2px rgba(0,0,0,0.75);
                box-shadow: 0px 0px 14px -2px rgba(0,0,0,0.75);
               
            }
            
            b{
                color: #ff6666;
                font-weight: lighter;
                font-family: monospace;
            }
        </style>
    </head>
    <body>
        <section class='container'>
            <h1>Frame framework 1.0</h1>
            <fieldset><legend>Rapport d'erreur Frame Framework 1.0</legend>
                <fieldset>
                    <legend>Details Frame Framework 1.0</legend>
                    <b>MESSAGE:</b><br/>
                    <?php 
                        echo $msg;
                    ?>
                    <b>CODE:</b><br/>
                    <?php 
                        echo $code.'<br/>';
                    ?>
                    <b>FICHIER:</b><br/>
                    <?php 
                        echo $fichier.'<br/>';
                    ?>
                    <b>Ligne:</b><br/>
                    <?php 
                        echo $ligne.'<br/>';
                    ?>
                </fieldset><br/>
                <fieldset>
                    <legend>Trace Frame Framework 1.0</legend>
                    <b>TRACE:</b><br/>
                    <?php 
                        echo $trace.'<br/>';
                    ?>
                    <b>SEVERITE:</b><br/>
                    <?php 
                        echo $severite;
                    ?>
                </fieldset>
        </section>
    </body>
</html>
