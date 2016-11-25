<?php

namespace Controller;

use \W\Controller\Controller;
use Model\SalonsModel;
use Model\MessagesModel;

class SalonController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function seeSalon($id)
	{
        $salonsModel = new SalonsModel();
        $salon = $salonsModel->find($id);
        $messagesModel = new MessagesModel();
        $messages = $messagesModel->search(array('id_salon'=>$id), 'OR', FALSE);
        
		$this->show('salons/see', array('salon' => $salon,'messages' => $messages));
	}

}