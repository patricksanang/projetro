<?php
namespace Applications\Authentification\Modules\Authentification;
use Library\BackController;
use Library\HTTPRequest;
use Library\HTTPResponse;
use Library\Entities\User;
use Library\Controls;
use Library\Backup;

class SolveController extends BackController{
    public function executeSolve(HTTPRequest $http){
    
        $result="ca marche!";
        json_encode($result);
    }
}