<?php
namespace Library;

/**
 * Description of User
 *
 * @author hubert
 */
 
session_start();
 
class Session
{

    public function __construct(){
      
    }

    public function destroy(){
      session_destroy();
    }

    public function existAttribut($nom){
      return isset($_SESSION[$nom]);
    }

    public function getAttribute($attr)
    {
      if($this->existAttribut($attr)){
          return $_SESSION[$attr];
      }else{
          throw new \Exception("Attribut '$attr' dosent exist");
      }

    }

    public function setAttribute($attr, $value)
    {
      $_SESSION[$attr] = $value;
    }

    public function isAuthenticated(){
        return isset($_SESSION['auth']);
    }

    public function setAuthenticated($bool){
      if($bool){
        $this->setAttribute('auth' , true);
      }else{
        unset($_SESSION['auth']);
      }
    }
}