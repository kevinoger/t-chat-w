<?php

namespace Controller;

use \W\Controller\Controller;

class TestController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function monAction()
	{
		$this->show('test/index');
	}

}