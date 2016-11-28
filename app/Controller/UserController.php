<?php

namespace Controller;

use Model\utilisateursModel;
    
class UserController extends BaseController
{
    
    
	public function listUsers() {
        $usersModel = new UtilisateursModel();
        
        $usersList = $usersModel->findAll();
        
        $this->show('users/list', array('listUsers' => $usersList));
    }

}