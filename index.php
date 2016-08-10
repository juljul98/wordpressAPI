<?php
	/*
	Plugin Name: Authentication
	Description: This is an Authentication Plugin design for wordpress
	Author: Julius DS. Mateo
	*/
	define( 'AUTH_VERSION', 'v1' );

	define( 'AUTH_AUTHOR_NAME', 'Julius DS. Mateo' );

	define( 'AUTH_PLUGIN_INDEX', __FILE__ ); // eg. C:\xampp\htdocs\demo\wp-content\plugins\auth\index.php

	define( 'AUTH_PLUGIN_BASENAME',
		plugin_basename( AUTH_PLUGIN_INDEX ) ); // eg. auth/index.php

	define( 'AUTH_PLUGIN_NAME',
		trim( dirname( AUTH_PLUGIN_BASENAME ), '/' ) ); // eg. auth

	define( 'AUTH_PLUGIN_DIR',
		untrailingslashit( dirname( AUTH_PLUGIN_INDEX ) ) ); // eg. C:\xampp\htdocs\demo\wp-content\plugins\auth

	define( 'AUTH_PLUGIN_URL',
		untrailingslashit( plugins_url( '', AUTH_PLUGIN_INDEX ) ) ); // eg. http://localhost:8080/demo/wp-content/plugins/auth

 
	require_once AUTH_PLUGIN_DIR . '/dashboard/index.php';
	require_once AUTH_PLUGIN_DIR . '/client/index.php';

	add_action( 'admin_menu', 'authentication_menu' );


	
	add_shortcode( 'login', 'login_func' );
	add_shortcode( 'logout', 'logout_func' );



?>