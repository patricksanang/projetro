<?php
namespace Library;

/**
 * Description of Entity
 *
 * @author hubert
 */

abstract class Entity implements \ArrayAccess , \JsonSerializable
{
    protected $erreurs = array();
    protected $id=0;

    public function __construct(array $donnees = array())
    {
            if(!empty($donnees))
            {
                    $this->hydrate($donnees);
            }
    }

    public function isNew(){
            return $id === 0;
    }

    public function erreurs(){
            return $this->erreurs;
    }

    public function getId(){
            return $this->id;
    }



    public function setId($id){
        $this->id = (int)$id;
    }

    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value) {
                $methode = 'set'.ucfirst($key);

                if(is_callable(array($this,$methode))){
                        $this->$methode($value);
                }
        }
    }

    public function offsetGet($var)
    {
        $method = 'get'.ucfirst($var);
        if (isset($var) && is_callable(array($this, $method)))
        {
            return $this->$method();
        }else{
            echo "on accede a l'inexistant : ".$var."<br>";       
        }
    }

    public function offsetSet($var, $value)
    {
        $method = 'set'.ucfirst($var);
        if (isset($var) && is_callable(array($this, $method)))
        {
                $this->$method($value);
        }else{
            
        }
    }


    public function offsetExists($var)
    {
        $method = 'get'.ucfirst($var);
        return isset($var) && is_callable(array($this, $method));
    }

    public function offsetUnset($var)
    {
        throw new \Exception('Impossible de supprimer une quelconque
        valeur');
    }

    public function jsonSerialize() {
        $getter_names = get_class_methods(get_class($this));
        $gettable_attributes = array();
        foreach ($getter_names as $key => $value) {
            if(substr($value, 0, 3) === 'get') {
                $gettable_attributes[lcfirst(substr($value, 3, strlen($value)))] = $this->$value();
            }
        }
        return $gettable_attributes;
    }
}