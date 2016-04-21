<?php
namespace Library\Entities;
use Library\Entity;

class Contact extends Entity{
	
    protected $nom;

    protected $prenom;

    protected $email;


    protected $numeros = array();




    /**
     * Gets the value of nom.
     *
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Sets the value of nom.
     *
     * @param mixed $nom the nom
     *
     * @return self
     */
    protected function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Gets the value of prenom.
     *
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Sets the value of prenom.
     *
     * @param mixed $prenom the prenom
     *
     * @return self
     */
    protected function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    protected function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }


    /**
     * Gets the value of numeros.
     *
     * @return mixed
     */
    public function getNumeros()
    {
        return $this->numeros;
    }

    /**
     * Sets the value of numeros.
     *
     * @param mixed $numeros the numeros
     *
     * @return self
     */
    protected function setNumeros($numeros)
    {
        $this->numeros = $numeros;

        return $this;
    }
}