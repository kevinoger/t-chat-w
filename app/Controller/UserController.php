<?php

namespace Controller;

use Model\UtilisateursModel;
use W\Security\AuthentificationModel;
use \Respect\Validation\Validator as v;
use \Respect\Validation\Exceptions\NestedValidationException;

class UserController extends BaseController
{
	/**
	 * Cette fonction sert à afficher la liste des utilisateurs
	 */
	public function listUsers() {
//		$usersList = array(
//			'Googleman', 'Pausewoman', 'Pauseman', 'Roland'
//		);
		
		/*
		 * Ici j'instancie depuis l'action du contrôleur un modèle d'utilisateurs
		 * pour pouvoir accéder à la liste des utilisateurs
		 */
		$usersModel = new UtilisateursModel();
		
		$usersList = $usersModel->findAll();
		
		// la ligne suivante affiche la vue présente dans app/Views/users/list.php
		// et y injecte le tableau $usersList sous un nouveau nom $listUsers
		$this->show('users/list', array('listUsers' => $usersList));
	}
	
	public function login() {
//		 on va utiliser le model d'Authentification et plus particulièrement
//		 la méthode isValidLoginInfos à laquelle on passera en param
//		 le pseudo/email et le password envoyés en post par l'utilisateur
//		 une fois cette vérification faite, on récupère l'utilisateur en bdd
//		 on le connecte et on le redirige vers la page d'accueil
		if( !empty($_POST)) {
			// je vérifie la non-vacuité du pseudo en POST
			if( empty($_POST['pseudo'])) {
				// si le pseudo est vide on ajoute un message d'erreur
				$this->getFlashMessenger()->error('Veuillez entrer un pseudo');
			}
			// je vérifie la non-vacuité du mot de passe en POST
			if( empty($_POST['mot_de_passe'])) {
				// si le mot de passe est vide on ajoute un message d'erreur
				$this->getFlashMessenger()->error('Veuillez entrer un mot de passe');
			}
			
			$auth = new AuthentificationModel();
			
			if( ! $this->getFlashMessenger()->hasErrors()) {
				// vérification de l'existence de l'utilisateur
				$idUser = $auth->isValidLoginInfo($_POST['pseudo'], $_POST['mot_de_passe']);
				
				// si l'utilisateur existe bel et bien...
				if($idUser !== 0){
					$utilisateurModel = new UtilisateursModel();
					
					// ... je récupère les infos de l'utilisateur et je m'en
					// sers pour le connecter au site à l'aide de $auth->logUserIn
					$userInfos = $utilisateurModel->find($idUser);
					$auth->logUserIn($userInfos);
					
					// une fois l'utilisateur connecté, je le redirige vers l'accueil
					$this->redirectToRoute('default_home');
				} else {
					// les infos de connexion sont incorrectes, on avertit 
					// l'utilisateur
					$this->getFlashMessenger()->error('Vos informations de connexion sont incorrectes');
				}
				
			}
			
		}
		
		$this->show('users/login', array('datas' => isset($_POST) ? $_POST : array()));
	}
	
	public function logout() {
		$auth = new AuthentificationModel();
		$auth->logUserOut();
		$this->redirectToRoute('login');
	}
	
	public function register() {
		if( ! empty($_POST)) {
			
			// on indique à respect validation que nos règles de validation
			// seront accessibles depuis le namespace Validation\Rules
			v::with("Validation\Rules");
			
			$validators = array(
				'pseudo' => v::length(3,50)
					->alnum()
					->noWhiteSpace()
					->usernameNotExists()
					->setName('Nom d\'utilisateur'),
				
				'email' => v::email()
					->emailNotExists()
					->setName('Email'),
				
				'mot_de_passe' => v::length(3,50)
					->alnum()
					->noWhiteSpace()
					->setName('Mot de passe'),
				
				'sexe' => v::in(array('femme', 'homme', 'non-défini')),
				
				'avatar' => v::optional(
						v::image()
						->size('0', '1MB')
						->uploaded()
					)
				
			);
			
			$datas = $_POST;
			
			// on ajouter le chemin vers le fichier d'avatar qui a été uploadé
			// (s'il y en a un)
			
			if( !empty($_FILES['avatar']['tmp_name'])) {
				// je stocke en données à valider le chemin vers la localisation
				// temporaire de l'avatar
				$datas['avatar'] = $_FILES['avatar']['tmp_name'];
			} else {
				// sinon je laisse ce champ vide
				$datas['avatar'] = '';
			}
			
			// je parcours la liste de mes validateurs en récupérant aussi le
			// nom du champ en clé
			
			foreach ($validators as $field => $validator) {
				// la méthode assert renvoie une exception de type NestedValidationException
				// qui nous permet de récupérer le ou les messages d'erreur
				// en cas d'erreur.
				try{
					// on essaye de valider la donnée
					// si une exception se produit, c'est le bloc catch qui sera
					// exécuté
					$validator->assert(isset($datas[$field]) ? $datas[$field] : '');
				} catch (NestedValidationException $ex) {
					$fullMessage = $ex->getFullMessage();
					$this->getFlashMessenger()->error($fullMessage);
				}
			}
			
			if( ! $this->getFlashMessenger()->hasErrors()) {
				// si on n'a pas rencontré d'erreur, on procède à l'insertion
				// du nouvel utilisateur
				
				// avant l'insertion, on doit faire deux choses :
				// - déplacer l'avatar du fichier temporaire vers le dossiers avatars/
				// - hâcher le mot de passe
				
				// on hâche d'abord le mot de passe. On utilise pour cela le modèle
				// AuthentificationModel pour rester cohérent avec le framework
				
				$auth = new AuthentificationModel(); 
				
				$datas['mot_de_passe'] = $auth->hashPassword($datas['mot_de_passe']);
				
				// on déplace l'avatar vers le dossier avatars
				
				if( ! empty($_FILES['avatar']['tmp_name'])) {
					$initialAvatarPath = $_FILES['avatar']['tmp_name'];
					$avatarNewName = md5(time() . uniqid());

					$targetPath = realpath('assets/uploads');

					move_uploaded_file($initialAvatarPath, $targetPath.'/'.$avatarNewName);

					// on met à jour le nouveau nom de l'avatar dans $datas
					$datas['avatar'] = $avatarNewName;
				} else {
					$datas['avatar'] = 'default.png';
				}
				
				
				$utilisateursModel = new UtilisateursModel();
				
				unset($datas['send']);
				
				$userInfos = $utilisateursModel->insert($datas);
				
				$auth->logUserIn($userInfos);
				
				$this->getFlashMessenger()->success('Vous vous êtes bien inscrit à T\'Chat !');
				
				$this->redirectToRoute('default_home');
			}
		}
		
		$this->show('users/register');
	}
}