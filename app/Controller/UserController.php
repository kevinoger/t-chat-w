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
        if(!empty($_POST)) {
            if(empty($_POST['pseudo'])) {
                $this->getFlashMessenger()->error('Veuillez entrer un pseudo');
            }
            
            if(empty($_POST['mot_de_passe'])) {
                $this->getFlashMessenger()->error('Veuillez entrer un mot de passe');
            }
             $AuthentificationModel = new AuthentificationModel();
        
            if(! $this->getFlashMessenger()->hasErrors()) {
                $idUser = $AuthentificationModel->isValidLoginInfo($_POST['pseudo'], $_POST['mot_de_passe']);
                    if($idUser !== 0) {
                    $utilisateurModel = new UtilisateursModel();
                    $userInfos = $utilisateurModel->find($idUser);
                    $AuthentificationModel->logUserIn($userInfos);
                    $this->redirectToRoute('default_home');
                    } else {
                        $this->getFlashMessenger()->error('Vos informations de connexion sont incorrectes');
                    }
            }
        }
        
       
        
        
        
        
        $this->show('users/login', array('datas' => $_POST) ? $_POST : array());
    
    }
    
    public function logout() {
        $AuthentificationModel = new AuthentificationModel();
        $AuthentificationModel->logUserOut();
        $this->redirectToRoute('login');
    }
    
    public function register() {
        $this->show('users/register');
    }
}
