<?php

namespace Controller;

use Model\SalonsModel;
use Model\MessagesModel;

class SalonController extends BaseController
{

	/**
	 * Page d'accueil par défaut
	 */
	public function seeSalon($id)
	{
        $salonsModel = new SalonsModel();
        $salon = $salonsModel->find($id);
        $messagesModel = new MessagesModel();
        $messages = $messagesModel->searchAllWithUserinfo($id);
        
		$this->show('salons/see', array('salon' => $salon,'messages' => $messages));
	}

}