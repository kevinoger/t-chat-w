<?php

namespace Controller;

use \W\Controller\Controller;

class UserController extends Controller
{
    
    
	public function listUsers() {
        $usersList = array(
            'Googleman', 'Pausewoman', 'Pauseman', 'Roland'
        );
        $this->show('users/list', array('listUsers' => $usersList));
    }

}