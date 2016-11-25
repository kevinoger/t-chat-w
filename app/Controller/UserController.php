<?php

namespace Controller;

use \W\Controller\Controller;
use Model\utilisateursModel;
    
class UserController extends Controller
{
    
    
	public function listUsers() {
        $usersModel = new UtilisateursModel();
        
        $usersList = $usersModel->findAll();
        
        $this->show('users/list', array('listUsers' => $usersList));
    }

}