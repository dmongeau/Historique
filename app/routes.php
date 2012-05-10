<?php



return array(

	'/' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'home'
		)
	),
	
	/*
	 *
	 * À propos
	 *
	 */
	'/a-propos/' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'about'
		)
	),
	'/a-propos/:action.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'about'
		)
	),
	
	/*
	 *
	 * Inscription
	 *
	 */
	'/inscription.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'register'
		)
	),
	'/inscription/confirmation.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'register',
			'action' => 'confirm'
		)
	),
	
	/*
	 *
	 * Événements
	 *
	 */
	'/evenements/ajouter.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'events',
			'action' => 'add'
		)
	),
	'/evenements/:year/:month/:day/:id.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'events',
			'action' => 'view'
		)
	),
	'/evenements/:year/:month/:day/:id/modifier.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'events',
			'action' => 'edit'
		)
	),
	
	
	
	/*
	 *
	 * Login
	 *
	 */
	'/connexion.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'login'
		)
	),
	'/connexion/mot-de-passe-oublie.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'login',
			'action' => 'forgot'
		)
	),
	'/connexion/changement-mot-de-passe.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'login',
			'action' => 'change'
		)
	),
	'/deconnexion.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'login',
			'action' => 'logout'
		)
	),
	
	
	
	'/tags/' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'tags'
		)
	),
	'/tags.json' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'tags',
			'format' => 'json'
		)
	),
	
	
	'/dossiers/' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'folders'
		)
	),
	'/dossiers.json' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'folders',
			'format' => 'json'
		)
	),
	'/dossiers/ajouter.html' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'folders',
			'action' => 'add'
		)
	),
	'/dossiers/ajouter.json' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'folders',
			'action' => 'add',
			'format' => 'json'
		)
	),
	
	
	'/*' => array(
		'page' => 'controller.php',
		'params' => array(
			'module' => 'home'
		)
	),
	
);