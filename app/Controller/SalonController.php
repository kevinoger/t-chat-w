<?php

namespace Controller;

use Model\SalonsModel;
use Model\MessagesModel;

class SalonController extends BaseController
{
	/**
	 * Cette action permet de voir la liste des messages d'un salon
	 * @param int $id l'id du salon dont je cherche à voir les messages
	 */
	public function seeSalon($id) {
		/*
		 * On instancie le modèle des salons de façon à récupérer les informations
		 * du salon dont l'id est $id (passé dans l'url)
		 */
		$salonsModel = new SalonsModel();
        
		$salon = $salonsModel->find($id);
		
		/*
		 * On instancie le modèles des messages pour récupérer les messages du
		 * salon dont l'id est $id
		 */
        $messagesModel = new MessagesModel();
		
        
        
        
        $connecteAdmin = $this->getUser();
        
        if($this->getUser()) {
            if(!empty($_POST['message'])) {
                $user = $this->getUser();
                $msgInsert = array(
                'corps'=>$_POST['message'],
                'date_creation'=>date('Y-m-d H:i:s'),
                'date_modification'=>date('Y-m-d H:i:s'),
                'id_utilisateur'=>$connecteAdmin['id'],
                'id_salon'=>$id
            );
            $messagesModel->insert($msgInsert);

            }
        } else {
            $this->getFlashMessenger()->error('Vous devez etre connecter pour poster un message');
        }
        
        /*
		 * J'utilise une méthode propre au modèle MessagesModel qui permet de 
		 * récupérer les messages avec les infos utilisateur associées
		 */
		$messages = $messagesModel->searchAllWithUserInfos($id);
        $this->show('salons/see', array('salon' => $salon, 'messages' => $messages));
	}
    
    
    public function newMessages($idSalon, $idMessage) {
        $messagesModel = new MessagesModel();
        
        $messagesModel->searchAllWithUserInfos($idSalon, $idMessage);
        
        $this->show('salons/newMessages', array('messages' => $messages));
    }
}