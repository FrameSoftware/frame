<?php 
Class Admins {

protected $Id_u; 
protected $Nom; 
protected $Prenom; 
public function setId_u ($value){
	 $this->Id_u = $value;
}
public function setNom ($value){
	 $this->Nom = $value;
}
public function setPrenom ($value){
	 $this->Prenom = $value;
}
public function hydrate($param = NULL){
	if(isset($param['Id_u'])){
		$this->setId_u($param['Id_u']);
	}
	if(isset($param['Nom'])){
		$this->setNom($param['Nom']);
	}
	if(isset($param['Prenom'])){
		$this->setPrenom($param['Prenom']);
	}
}
}