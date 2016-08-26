<?php 
Class ClientEntity {

public function __construct($param){
	 $this->hydrate($param);
}

protected $Id_client; 
protected $Nom; 
protected $Pnom; 
protected $Login; 
protected $Pass; 
protected $Salt; 
protected $Avatar; 
public function getId_client (){
	return $this->Id_client ;
}
public function getNom (){
	return $this->Nom ;
}
public function getPnom (){
	return $this->Pnom ;
}
public function getLogin (){
	return $this->Login ;
}
public function getPass (){
	return $this->Pass ;
}
public function getSalt (){
	return $this->Salt ;
}
public function getAvatar (){
	return $this->Avatar ;
}
public function setId_client ($value){
	 $this->Id_client = $value;
}
public function setNom ($value){
	 $this->Nom = $value;
}
public function setPnom ($value){
	 $this->Pnom = $value;
}
public function setLogin ($value){
	 $this->Login = $value;
}
public function setPass ($value){
	 $this->Pass = $value;
}
public function setSalt ($value){
	 $this->Salt = $value;
}
public function setAvatar ($value){
	 $this->Avatar = $value;
}
public function hydrate($param = NULL){
	if(isset($param['Id_client'])){
		$this->setId_client($param['Id_client']);
	}
	if(isset($param['Nom'])){
		$this->setNom($param['Nom']);
	}
	if(isset($param['Pnom'])){
		$this->setPnom($param['Pnom']);
	}
	if(isset($param['Login'])){
		$this->setLogin($param['Login']);
	}
	if(isset($param['Pass'])){
		$this->setPass($param['Pass']);
	}
	if(isset($param['Salt'])){
		$this->setSalt($param['Salt']);
	}
	if(isset($param['Avatar'])){
		$this->setAvatar($param['Avatar']);
	}
}
}