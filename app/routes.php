<?php
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'default_home'],
		['GET', '/test', 'Test#monAction', 'test_index'],
		['GET', '/users', 'User#listUsers', 'users_list'],
		['GET|POST', '/salon/[i:id]', 'Salon#seeSalon', 'see_salon'],
		['GET|POST', '/login', 'User#login', 'login'],
		['GET', '/logout', 'User#logout', 'logout'],
		['GET|POST', '/register', 'User#register', 'register']
	);