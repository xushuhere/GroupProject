
	<?php
	session_start();
	//define ( 'DB_HOST', 'localhost' );
        define ( 'DB_HOST', '127.0.0.1' );
	//define ( 'DB_USER', 'cyrix' );
        define ( 'DB_USER', 'root' );
	define ( 'DB_PASS', 'hello123' );
	//define ( 'DB_PASS', 'hxf' );
	define ( 'DB_NAME', 'handymantools' );
	$_SESSION['host']  = DB_HOST;
	$_SESSION['dbuser']= DB_USER;
	$_SESSION['dbpass']= DB_PASS;
	$_SESSION['dbname']= DB_NAME;
	
	$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (! $dbc) {
		echo "Cannot connect to database.";
		exit ();
	}

		$login = mysqli_real_escape_string ( $dbc, trim ( $_POST ["input_text"] ) );
		$password = mysqli_real_escape_string ( $dbc, trim ( $_POST ["input_password"] ) );
		if ($_POST ['user'] == "customer") {
			$query0 = "SELECT * FROM CUSTOMERS WHERE Email='$login' AND Password='$password'";
                        $query1 = "SELECT * FROM CUSTOMERS WHERE Email='$login' ";
			$result0 = mysqli_query ( $dbc, $query0 );
			$result1 = mysqli_query ( $dbc, $query1 );
			if (mysqli_num_rows($result0)==1) {
				$_SESSION["customer"]=$login;
				header("Location: CustMainMenu.html");
				exit ();
			} 
                        elseif (mysqli_num_rows($result1)>0) {
                                echo "Wrong password";
				header("Location: Login.html"); 
				exit ();
                        }
                        else {
                                $_SESSION["user"]=$user;
				header("Location: NewUser.html"); 
				exit ();
			}
		} else if($_POST ['user'] == "clerk"){
			$query3 = "SELECT * FROM CLERKS WHERE Login='$login' AND Password='$password'";
			$query4 = "SELECT * FROM CLERKS WHERE Login='$login' ";
                        $result3 = mysqli_query ( $dbc, $query3 );
                        $result4 = mysqli_query ( $dbc, $query4 );
			if (mysqli_num_rows($result3)>0) {
				$_SESSION["clerk"]=$login;
				header ("Location: ClerkMainMenu.html");
				exit();
			} 
                        elseif (mysqli_num_rows($result4)>0) {
                                echo "Wrong password";
                                header ("Location: Login.html");
				exit();
			} 
                        else {
                            	header ("Location: Login.html");
				exit();
			}
		}
		else header ("Location: Login.html");

	mysqli_close ( $dbc );
	
	?>
