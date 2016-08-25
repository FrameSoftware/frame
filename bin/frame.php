#!/cli/php
Bienvenu dans Frame Code generator :
<?php
    if($argv[1] != 'generate:bundle'){
        echo "erreur voici la liste des arguments utilisable pour le moment: \n";
        echo "\n\n------generate:bundle [nom_du_bundle]";
        echo "\n\n------ Bye Bye";
        return;
    }
    
    if(!isset($argv[2])){
        echo 'Vous devez donner un nom de bundle';
        return ;
    }
    
    $bundle_name ='Bundle'. ucfirst(strtolower($argv[2]));//la premiere lettre en majuscule
    $bundle_folder = "../src/".$bundle_name;
    try{
        mkdir($bundle_folder);
        mkdir($bundle_folder.'/controller');
        mkdir($bundle_folder.'/view');
        if(file_exists("controller.php")){
            $fichier_controllleur = $bundle_folder."/controller/ControlleurDefault.php";
            $controlleru_file = fopen($fichier_controllleur, "a");
            $code_controlleur ="<?php\n"
                    . "include_once './core/FrameController.php';\n"
                    . "\n"
                    . "use core\FrameController as FController;\n\n"
                    . "class ControlleurDefault extends  FController\FrameController {\n"
                    . "\tpublic function __construct(\$arg = null){\n"
                    . "\t\tparent::__construct(\$arg);"
                    . "}"
                    . "\tpublic function indexAction(){\n"
                    . "\techo 'Je suis le controlleur par defaut  de ".$bundle_name." et je fonctionne';\n"
                    . "  }\n"
                    . "}";
            fputs($controlleru_file,$code_controlleur);
            fclose($controlleru_file);
        }
        
        
        echo "Le namespace Bundle '$bundle_name' sera cree dans ce repertoire\n";
        echo "Le Bundle '$bundle_name' a ete cree avec succes";
    } catch (Exception $ex) {
        echo 'Erreur [ '.$ex->getMessage().' ] ';
        return;
    }
?>
