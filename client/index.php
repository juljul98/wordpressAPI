<?php

	function auth_func($username, $password) {
   	$user = get_user_by( 'login', $username );
	if ( $user && wp_check_password( $password, $user->data->user_pass, $user->ID) )
	   $count_row = 1;
	   if($count_row == 1) {
	   	session_start();
	   	$_SESSION['login'] = TRUE;
	    $_SESSION['id'] = $user->ID;
	   	echo $user->ID;
	   }
	else
	   echo "Wrong Username and Password";
	}

	function cookie_func($username) {
		setcookie('user', $username, time()+3600);
	}

	function session_destroy_func() {
		
	}

	function login_func() { ?>
		<?php 
			 if(isset($_REQUEST['login'])) {
	       		$username = $_POST['username'];
	      		$password = $_POST['password'];
	      		auth_func($username, $password);
	       	 }
	       	 if(isset($_POST['remember'])) {
	       	 	cookie_func($username);
	       	 }
		 ?>
		<form method="POST" action="">
			<label for="username">Username</label><input type="text" name="username" id="username"><br>
			<label for="password">Password</label><input type="password" name="password" id="password"><br>
			<label for="remember">Remember me</label><input type="checkbox" name="remember" id="remember"><br>	
			<input type="submit" name="login" value="login">
		</form>
	<?php
	}

	function logout_func() { 
		session_start();
		if(isset($_GET['q'])) {
			$_SESSION['login'] = FALSE;
			session_destroy();
		}
		?>
		<a href="?q">Logout</a>
	<?php	
	}
?>