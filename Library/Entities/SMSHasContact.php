<?php
namespace Library\Entities;
use Library\Entity;
use Library\Entities\Contact;
use Library\Entities\SMS;

class SMSHasContact extends Entity{
	protected $contact;

    protected $sms;

    protected $status;

    protected $dateEnvoie;

    

    /**
     * Gets the value of contact.
     *
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Sets the value of contact.
     *
     * @param mixed $contact the contact
     *
     * @return self
     */
    protected function setContact(Contact $contact)
    {
        $this->contact = $contact;

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
    protected function setSms(SMS $sms)
    {
        $this->sms = $sms;

        return $this;
    }

    /**
     * Gets the value of status.
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the value of status.
     *
     * @param mixed $status the status
     *
     * @return self
     */
    protected function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Gets the value of dateEnvoie.
     *
     * @return mixed
     */
    public function getDateEnvoie()
    {
        return $this->dateEnvoie;
    }

    /**
     * Sets the value of dateEnvoie.
     *
     * @param mixed $dateEnvoie the date envoie
     *
     * @return self
     */
    protected function setDateEnvoie($dateEnvoie)
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }
}