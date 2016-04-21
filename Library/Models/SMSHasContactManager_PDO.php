<?php
namespace Library\Models;
use Library\Entities\SMSHasContact;
use Library\Entities\SMS;
use Library\Entity;
use Library\Models\SMSManager_PDO;
use Library\Models\ContactManager_PDO;
use Library\Managers;
use Library\PDOFactory;
use Library\Utilities;
class SMSHasContactManager_PDO extends ManagerCrud{

	public function __construct($dao){
		parent::__construct($dao);
		$this->mapping = array(
				'id'=>'id_sms_has_contact',
				'sms'=>'sms_idsms',
				'contact'=>'contact_idcontact',
				'status'=>'etat',
				'dateEnvoie'=>'dateEnvoie',
			);
		$this->table_name = 'sms_has_contact';
	}


	public function map(){
		$sql = "";

		foreach($this->mapping as $key=>$val){
			if($key != 'id' || true){
				if($key == 'dateEnvoie'){
					$sql = $sql . " " . $val . "=FROM_UNIXTIME(:" . $key . ") ,";
					
				}else{
					$sql = $sql . " " . $val . "=:" . $key . " ,";
				}
			}
		}
		$sql[strlen($sql)-1]=';';

		return $sql;
	}

	

	public function bindValue($query , Entity $entity){

            //Utilities::print_table($query);
		foreach($this->mapping as $key=>$val){
			if($key != 'status' && $key != 'id' && $key != 'dateEnvoie'){
				$query->bindValue($key , $entity[$key]['id']);
			}else{
				$query->bindValue($key , $entity[$key]);
			}
		}

		return $query;
	}

	public function fetch($query){
		$results = $query->fetchAll();
		$data= array();
		//sms manager
		$sms_manager = new SMSManager_PDO($this->dao);
        $contact_manager = new ContactManager_PDO($this->dao);
        foreach($results as $r){
            $p=$this->entity_class();
            $element=new $p();

            $element['id'] = $r['id'];
			$element['status']=$r['status'];
                        $element['dateEnvoie']=$r['dateEnvoie'];
			$element['sms'] = $sms_manager->find(array('id'=>$r['sms']))[0];
			$element['contact'] = $contact_manager->find(array('id'=>$r['contact']))[0];
			$element['dateEnvoie'] = $r['dateEnvoie'];
			$data[] = $element;
		}
		return $data;
	}
}