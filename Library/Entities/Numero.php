<?php
namespace Library\Entities;
use Library\Entity;

class Numero extends Entity{
	/**
	* 	nom du departement
	*	@var string
	**/
	protected $numero;

    protected $idContact;



    

    /**
     * Gets the value of numero.
     *
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Sets the value of numero.
     *
     * @param mixed $numero the numero
     *
     * @return self
     */
    protected function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Gets the value of idContact.
     *
     * @return mixed
     */
    public function getIdContact()
    {
        return $this->idContact;
    }

    /**
     * Sets the value of idContact.
     *
     * @param mixed $idContact the id contact
     *
     * @return self
     */
    protected function setIdContact($idContact)
    {
        $this->idContact = $idContact;

        return $this;
    }
}