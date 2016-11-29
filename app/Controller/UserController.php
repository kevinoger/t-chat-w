<?php

namespace Controller;

use Model\utilisateursModel;
use W\Security\AuthentificationModel;
use \Respect\Validation\Validator as v;
use \Respect\Validation\Exceptions\NestedValidationException;
    
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
        
        if(!empty($_POST)) {
            
            v::with('Validation\Rules');
            
            $validators = array(
                'pseudo' => v::length(3,50)->alnum()->noWhiteSpace()->usernameNotExists()->setName('Nom d\'utilisateur'),
                'email' => v::email()->emailNotExists()->setName('Email'),
                'mot_de_passe' => v::length(3,50)->alnum()->noWhiteSpace()->setName('Mot de passe'),
                'sexe' => v::in(['femme', 'homme', 'non-defini']),
                'avatar' => v::optional(v::image()->size('1MB')->uploaded())
            );
            
            $datas = $_POST;
            
            if(!empty($_FILES['avatar']['tmp_name'])) {
                $datas['avatar'] = $_FILES['avatar']['tmp_name'];
            } else {
                $datas['avatar'] = '';
            }
            
            foreach ($validators as $field => $validator) {
                try {
                    $validator->assert(isset($datas[$field]) ? $datas[$field] : '');
                } catch(NestedValidationException $ex) {
                    $fullMessage = $ex->getFullMessage();
                    $this->getFlashMessenger()->error($fullMessage);
                }
            }
            
            if( ! $this->getFlashMessenger()->hasErrors()) {
                
                $AuthentificationModel = new AuthentificationModel();
                
                $datas['mot_de_passe'] = $AuthentificationModel->hashPassword($datas['mot_de_passe']);
                
                $initialAvatarPath = $_FILES['avatar']['tmp_name'];
                
                $avatarNewName = md5(time().uniqid());
                
                $targetPath = realpath('assets/upload/'. $avatarNewName);
                
                move_uploaded_file($initialAvatarPath, $targetPath);
                
                $datas['avatar'] = $avatarNewName;
                
                $utilisateursModel = new UtilisateursModel();
                
                unset($datas['send']);
                
                $userInfos = $utilisateursModel->insert($datas);
                
                $AuthentificationModel->logUserIn($userInfos);
                
                $this->getFlashMessenger()->success('vous vous etes bien inscrit');
                
                $this->redirectToRoute('default_home');
            }
            
        }
        
        $this->show('users/register');
    }
}
