#!/cli/php
Bienvenu dans Frame Code generator :

<?php
/**
 * In this version of the entity generator we will generate code automatically whitout
 * flexibility it means that if the user specifier getter or setter it will generate those method
 * for all the attribute. The constructor and the hydrate method will have a parameter (null by default) 
 * and the constructor will call the hydrate method (which has an null by default param) and pass to him the param
 * 
 * 
 * Usage of this command line tool:
 * php frame_entity.php generate:entity [entity_name} {entity_attribute} {getter:setter}
 * 
 * generate:entity is required
 * entity_name is the name of the entity to create
 * entity_attribute is the list of attribute of the entity Note that they will be protected
 * getter:setter is not require and it represent if this tool will create the getter or the setter 
 *  usage :
 *      case 1: getter
 *          it will generate only getter of all attribute
 *      cas 2: setter
 *          it will generate only setter of all attribute
 *      cas 3 : getter:setter or setter:getter
 *          it will generate both of the two type of method
 */
function generate_getter($list_attr){
    ob_start();
    foreach ($list_attr as $attr):
        $attr = ucfirst(strtolower($attr));
        echo "public function get$attr (){\n"
                . "\treturn \$this->$attr ;\n"
                . "}\n";
    endforeach;
    return ob_get_clean();
}

function generate_setter($list_attr){
    ob_start();
    foreach ($list_attr as $attr):
        $attr = ucfirst(strtolower($attr));
        echo "public function set$attr (\$value){\n"
                . "\t \$this->$attr = \$value;\n"
                . "}\n";
    endforeach;
    return ob_get_clean();
}

    if($argv[1] != 'generate:entity'){
        echo "Error command not found \n";
        return;
    }
    
    if(!isset($argv[2])){
        echo 'Error entity name not found\n';
        return ;
    }
    
    $entity_name = ucfirst(strtolower($argv[2])).'Entity';
    $entity_path = '../src/Entity/'.$entity_name.'.php';
    
    if(!isset($argv[3])){
        echo 'Error entity attribute not specified\n';
        return ;
    }
    
    $entity_attr_list = explode(':', $argv[3]);
    //starting generate the code of the entity attributes
    ob_start();
    foreach ($entity_attr_list as $attr):
        $attr = ucfirst(strtolower($attr));
        echo "protected \$$attr; \n";
    endforeach;
    echo "\n";
    $bloc_attr = ob_get_clean();//the bloc of all the attribute definition
    
    //starting generate the hydate() function
    /**
     * The actual structure of this method is that
     * 
     * public function hydrate($param = null){
     *      if(isset($param['name_attr'])){
     *          $this->set[ParamNameInCamelCase]($param['name_attr']);
     *      }
     *      ......
     *      ......
     *      ......
     *      if(isset($param['name_attr'])){
     *          $this->set[ParamNameInCamelCase]($param['name_attr']);
     *      }
     * }
     * 
     */
    
    //the body of the function
    print('Generating hydrate method body (starting)\n');
    ob_start();
    foreach ($entity_attr_list as $attr):
        $attr = ucfirst(strtolower($attr));
        echo "\tif(isset(\$param['$attr'])){\n"
            ."\t\t\$this->set$attr(\$param['$attr']);\n"
            ."\t}\n";
    endforeach;
    $body_func_code = ob_get_clean();
    
    print('Generating hydrate method body (finish)\n');
    print('**************************************************');
    print('Generating hydrate method all (starting)\n');
    //generating all the method now
    ob_start();
    echo "public function hydrate(\$param = NULL){\n";
    echo $body_func_code;
    echo "}\n";
    $hydrate_func_code = ob_get_clean();//finally this variable contain all
    //the hydrate function code
    print('Generating hydrate method all (starting)\n');
    
    
    $getter_func_bloc = "";
    $setter_func_bloc = "";
    
    /**
     * In the case where the user specifie to create getter and setter
     */
    if(isset($argv[4]) ){//the getter:setter specification
        $methods = explode(':', $argv[4]);
        if(count($methods)>2){
            print('Error: number of method type exceded 2 will stop the entity generation process\n');
            return;
        }
        foreach($methods as $method):
            if($method == 'getter'){
                $getter_func_bloc =  generate_getter($entity_attr_list);
            }else if($method == 'setter'){
                $setter_func_bloc = generate_setter($entity_attr_list);
            }else{
                print 'Warning: unknow type of method asked to be create. Will pass\n';
            }
        endforeach;
    }
    
    /**
     * Start generating the class definition
     * 
     * Class $entity_name {
     *  [attr_definition here]
     * 
     *  [method here]
     * 
     * }
     */
    
    ob_start();
    
    echo "public function __construct(\$param){\n"
            . "\t \$this->hydrate(\$param);\n"
            . "}\n\n";
    $bloc_construct = ob_get_clean();
    
    
    ob_start();
    echo "<?php \n";
    echo "Class $entity_name {\n\n";
    echo $bloc_construct;
    echo $bloc_attr.'';
    echo $getter_func_bloc.'';
    echo $setter_func_bloc.'';
    echo $hydrate_func_code.'';
    echo '}';
    $class_code = ob_get_clean();
    //starting writing on the disk
    
    

    
    $class_file = fopen($entity_path, "a");
    fputs($class_file,$class_code);
    fclose($class_file);
    print 'The generating of entity class finish successfull :) n';