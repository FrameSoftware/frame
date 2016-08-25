<?php 

/*
*Cette fonction prend un tableau en parametre et genere les liens des ressources correspondantes 
* les parametres osnt : 
* folder 
* name
*/
function asset($type= array()){
	
	if(!isset($type['name']))//si le nom n'est pas definie on arrete tout
		return;

	if(isset($type['type']) && $type['type'] == 'css'){//on doit genere du code pour inclure le css
		echo '<link rel=\'stylesheet\' href=http://'.$_SERVER['SERVER_NAME'].'/'.APP_NAME.'/assets/css/'.$type['name'].' />';
	}

	if(isset($type['type']) && $type['type'] == 'js'){//on doit genere du code pour inclure le css
		echo '<script type=\'JavaScript\' src=http://'.$_SERVER['SERVER_NAME'].'/'.APP_NAME.'/assets/js/'.$type['name'].' >';
	}

	if(isset($type['type']) && $type['type'] == 'img'){//on doit genere du code pour inclure le css
		echo '<limg alt='.$type['alt'].' '.$type['html'].' href=http://'.$_SERVER['SERVER_NAME'].'/'.APP_NAME.'/assets/img/'.$type['name'].' />';
	}

}

function getAsset($assets = null){
	echo 'http://'.$_SERVER['SERVER_NAME'].'/'.APP_NAME.'/assets/'.$assets.'/';
}