<?php
namespace Library\Models;
use Library\Entity;
use Library\Manager;
use Library\Utilities;
use Library\Entities\Contact;
use Library\Entities\ContactHasGroupe;
use Library\Entities\Groupe;
use Library\Entities\Numero;
use Library\Entities\SMS;
use Library\Entities\SMSHasContact;
use Library\Entities\User;

/**
 * Description of Manager
 *
 * @author hubert
 */

class ManagerCrud extends Manager
{

	protected $table_name = "";

	protected $mapping = array();


	public function __construct($dao){
		parent::__construct($dao);
	}

	/*
	*
	* permte de faire un bindValue entre l'entité et la query
	*
	*/
	public function bindValue($query , Entity $entity){
		foreach($this->mapping as $key=>$val){
			if($key != 'id'){
				$query->bindValue($key , $entity[$key]);
			}
                        
		}
		return $query;
	}

	/*
	*
	*	fait correspondre les champs de la bases de données avec
	*	les noms de classe
	*/
	public function map(){
		$sql = "";

		foreach($this->mapping as $key=>$val){
			if($key != 'id'){
				$sql = $sql . " " . $val . "=:" . $key . " ,";
			}
		}
		$sql[strlen($sql)-1]=';';


		return $sql;
	}

	public function manager_class(){
		return get_class($this);
	}


	public function entity_class(){
		$user = str_replace('Manager_PDO', '', $this->manager_class() );
		$user = str_replace('Models' , 'Entities' , $user);
                
		return $user;
	}

	/*
	*
	*	pertmet de transforme le resultat d'une query en object 		
	*	correspondant
	*/
	public function fetch($query){

		$query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->entity_class());
		$results = $query->fetchAll();
		return $results;
	}

    public function create(Entity $entity){
		$sql = "INSERT INTO " . $this->table_name ." SET ";
		$sql .= $this->map();
		$query = $this->dao->prepare($sql);

        $query = $this->bindValue($query , $entity);

//		Utilities::print_table($query);
		$id=0;
		try{
    		$id =  $query->execute() ? $this->dao->lastInsertId() : 0;
		}catch(\Exception $e){
			//Utilities::print_table($query);
			throw new \Exception("Query faill !!! " . $e->getMessage());
		}    
		$entity['id'] = $id;
		return $id;
	}

	public function modify(Entity $entity){
		$sql = "INSERT INTO " . $this->table_name ." SET ";
		$sql .= $this->map();
		$sql = $sql . " WHERE " . $this->mapping['id'] . " =:id ";
		$query = $this->dao->prepare($sql);
		$query = $this->bindValue($query , $entity);
		
		return $query->execute();
	}

	public function delete(Entity $entity){
		$sql = "DELETE FROM " . $this->table_name . " WHERE " . $this->mapping['id'] . "=:id";
		$query = $this->dao->prepare($sql);
		$query->bindValue('id' , $entity['id']);

		return $query->execute();
	}

    public function find($data = array()){

		$sql = "SELECT " . $this->mapping['id'] . " as id ";

		foreach($this->mapping as $key=>$val){
			if($key != 'id'){
				$sql = $sql . " , " . $val . " as " . $key . " ";
			}
		}

		$sql .= " FROM " . $this->table_name . " ";

		if(!empty($data)){

			$sql .= " WHERE TRUE ";
			foreach($data as $key=>$d){
				if(isset($this->mapping[$key])){
					$sql .= " AND ". $this->mapping[$key] ."=:".$key." ";
				}
			}
		}
		$sql .= ' ORDER BY(id) DESC';
		$sql .=";";


	/*		Utilities::print_s("find query  : " );
		Utilities::print_s($sql);*/
		$query = $this->dao->prepare($sql);
		$query = $this->bind_search($query , $data);
		
		$query->execute();

		
		return $this->fetch($query);

	}

	public function bind_search($query , $data){
		foreach($data as $key=>$d){
			$query->bindValue($key , $d);
		}
		return $query;
	}

	public function get($id=0){
		$class = $this->entity_class();
		$result = $this->find(array('id'=>$id));
		if(count($result)>0){
			return $result[0];
		}else{
			return new $class;
		}
	}
}