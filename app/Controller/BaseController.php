<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\SalonsModel;

class BaseController extends Controller
{

	protected $engine;
    
    public function __construct() {
        $this->engine = new \League\Plates\Engine(self::PATH_VIEWS);
        
        $this->engine->loadExtension(new \W\View\Plates\PlatesExtensions());

		$app = getApp();
        
        $salonsModel = new SalonsModel();

		// Rend certaines données disponibles à tous les vues
		// accessible avec $w_user & $w_current_route dans les fichiers de vue
		$this->engine->addData(
			[
				'w_user' 		  => $this->getUser(),
				'w_current_route' => $app->getCurrentRoute(),
				'w_site_name'	  => $app->getConfig('site_name'),
				'salons'	      => $salonsModel->findAll(),
			]
		);
    }
    
    
    public function show($file, array $data = array()) {
        // Retire l'éventuelle extension .php
		$file = str_replace('.php', '', $file);

		// Affiche le template
		echo $this->engine->render($file, $data);
		die();
    }
    
    public function addGlobalData(array $datas) {
        $this->engine->addData($data);
    }
}