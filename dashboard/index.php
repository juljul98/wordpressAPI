<?php
	require_once AUTH_PLUGIN_DIR . '/dashboard/class-authentication-list-table.php';
	function authentication_menu() {
		add_menu_page(
		 "Authentication",
		 "Authentication",
		 0,
		 "authentication-menu-slug",
		 "authentication_options",
		 AUTH_PLUGIN_URL. '/images/key.png'
		 );

 		add_submenu_page(
 		 "authentication-menu-slug",
 		 "Login | Authentication",
 		 "Login",
 		 0,
 		 "login-authentication-submenu-slug",
 		 "login_authentication_options");

 		add_submenu_page(
 		 "authentication-menu-slug",
 		 "Registration | Authentication",
 		 "Registration",
 		 0,
 		 "registration-authentication-submenu-slug",
 		 "registration_authentication_options");
	}



	
	function authentication_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		 ?>
		 	 <link rel="stylesheet" href="<?php echo AUTH_PLUGIN_URL ?>/css/style.css">
			 <div class="welcome-panel" id="welcome-panel">
				 <h1>My Custom Authentication Plugin</h1>
				 
				 <p><b> Author :</b> <?php echo AUTH_AUTHOR_NAME ?></p>
				 <p><b> Version :</b> <?php echo AUTH_VERSION ?></p>
				<a class="welcome-panel-close" href="#">Exit</a>
			 </div>
			 <script src="<?php echo AUTH_PLUGIN_URL ?>/js/jquery-1.11.1.min.js"></script>
			 <script>
			 	$(document).ready(function() {
			 		$('.welcome-panel-close').click(function(e){
			 			e.preventDefault();
			 			$(this).parent().remove();
			 		});
			 	});
			 </script>
			<div class="wrap">
		<h2>Test API</h2>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<?php
								$customers_obj = new Authentication_List();
								$customers_obj->prepare_items();
								$customers_obj->display(); 
								print_r($customers_obj->get_users());
							?>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
	<?php
	}



	function login_authentication_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		echo "<h1>Login Area</h1>";
	}

	function registration_authentication_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		echo "<h1>Registration Area</h1>";
	}

?>