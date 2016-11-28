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
                
            }
            
            if(empty($_POST['email'])) {
                
            }
            
            if(empty($_POST['mot_de_passe'])) {
                
            }
        }
        
        $AuthentificationModel = new AuthentificationModel();
        
        if(!empty($_POST['pseudo']) && !empty($_POST['mot_de_passe'])) {
            $idUser = $AuthentificationModel->isValidLoginInfo($_POST['pseudo'], $_POST['mot_de_passe']);
                if($idUser !== 0) {
                $utilisateurModel = new UtilisateursModel();
                $userInfos = $utilisateurModel->find($idUser);
                $AuthentificationModel->logUserIn($userInfos);
                $this->redirectToRoute('default_home');
                } else {

                }
        }
        
        
        
        
        $this->show('users/login', array('datas' => $_POST) ? $_POST : array());
    
    }
    
    public function logout() {
        $AuthentificationModel = new AuthentificationModel();
        $AuthentificationModel->logUserOut();
        $this->redirectToRoute('login');
    }
}
