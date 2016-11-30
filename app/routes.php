<?php
	// quand on essaye d'accéder à localhost/t-chat/public/
	// l'url qui est réellement reçu est : localhost/t-chat/index.php/
	$w_routes = array(
		['GET', '/', 'Default#home', 'default_home'],
		['GET', '/test', 'Test#monAction','test_index'],
		['GET', '/users', 'User#listUsers', 'users_list'],
		['GET|POST', '/salon/[i:id]', 'Salon#seeSalon', 'see_salon'],
		['GET|POST', '/login', 'User#login', 'login'],
		['GET', '/logout', 'User#logout', 'logout'],
		['GET|POST', '/register', 'User#register', 'register'],
		['GET', '/newmessages/[i:idSalon]/[i:idMessage]', 'Salon#newMessages', 'new_messages']
	);