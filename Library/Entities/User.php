<?php
namespace Library\Entities;
use Library\Entity;

class User extends Entity{
	/**
	* username
	**/
	protected $nom;

        protected $prenom;

	/**
	* login
	**/
	protected $login;

	/**
	* password
	**/
	protected $password;

	/**
	* email
	**/
	protected $email;


	protected $sms = array();

	protected $contacts = array();

	protected $groupes = array();



	

    

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
     * Gets the value of login.
     *
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Sets the value of login.
     *
     * @param mixed $login the login
     *
     * @return self
     */
    protected function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Gets the value of password.
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the value of password.
     *
     * @param mixed $password the password
     *
     * @return self
     */
    protected function setPassword($password)
    {
        $this->password = $password;

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
     * Gets the value of sms.
     *
     * @return mixed
     */
    public function getSms()
    {
        return $this->sms;
    }

    /**
     * Sets the value of sms.
     *
     * @param mixed $sms the sms
     *
     * @return self
     */
    protected function setSms($sms)
    {
        $this->sms = $sms;

        return $this;
    }

    /**
     * Gets the value of contacts.
     *
     * @return mixed
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Sets the value of contacts.
     *
     * @param mixed $contacts the contacts
     *
     * @return self
     */
    protected function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * Gets the value of groupes.
     *
     * @return mixed
     */
    public function getGroupes()
    {
        return $this->groupes;
    }

    /**
     * Sets the value of groupes.
     *
     * @param mixed $groupes the groupes
     *
     * @return self
     */
    protected function setGroupes($groupes)
    {
        $this->groupes = $groupes;

        return $this;
    }
}