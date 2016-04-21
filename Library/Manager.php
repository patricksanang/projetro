<?php
namespace Library;
/**
 * Description of Manager
 *
 * @author hubert
 */

abstract class Manager
{
    protected $dao;

    public function __construct($dao)
    {
        $this->dao = $dao;
    }

}