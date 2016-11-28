<?php

namespace Controller;

use Model\utilisateursModel;
use W\Security\AuthentificationModel;
    
class UserController extends BaseController
{
    
    
	public function listUsers() {
        $usersModel = new UtilisateursModel();
        
        $usersList = $usersModel->findAll();
        
        $this->show('users/list', array('listUsers' => $usersList));
    }
    
    
    public function login() {
        $usersModel = new AuthentificationModel();
        
        
        
        $this->show('users/login');
    }
}
