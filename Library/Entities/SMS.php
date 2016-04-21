<?php
namespace Library\Entities;
use Library\Entity;

class SMS extends Entity{
	/**
	* 	nom du departement
	*	@var string
	**/
	
    protected $corps;


    protected $dateEnregistrement;





    /**
     * Gets the value of corps.
     *
     * @return mixed
     */
    public function getCorps()
    {
        return $this->corps;
    }

    /**
     * Sets the value of corps.
     *
     * @param mixed $corps the corps
     *
     * @return self
     */
    protected function setCorps($corps)
    {
        $this->corps = $corps;

        return $this;
    }

    

    /**
     * Gets the value of dateEnregistrement.
     *
     * @return mixed
     */
    public function getDateEnregistrement()
    {
        return $this->dateEnregistrement;
    }

    /**
     * Sets the value of dateEnregistrement.
     *
     * @param mixed $dateEnregistrement the date enregistrement
     *
     * @return self
     */
    protected function setDateEnregistrement($dateEnregistrement)
    {
        $this->dateEnregistrement = $dateEnregistrement;

        return $this;
    }

}