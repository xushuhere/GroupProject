<?php
session_start();
$host=$_SESSION['host'];
$user=$_SESSION['dbuser'];
$pass=$_SESSION['dbpass'];
$db=$_SESSION['dbname'];

$dbc = mysqli_connect ( $host,$user,$pass,$db );
	if (! $dbc) {
		echo "Cannot connect to database.";
		exit ();
	}
// 	if (isset ( $_POST ["submit"] )) {
// 		header("Location: NewUser.html");
// 		exit ();
		$email = mysqli_real_escape_string ( $dbc, trim ( $_POST ["email"] ) );
		$password = mysqli_real_escape_string ( $dbc, trim ( $_POST ["password"] ) );
		$conf_password = mysqli_real_escape_string ( $dbc, trim ( $_POST ["conf_password"] ) );
		$FirstName = mysqli_real_escape_string ( $dbc, trim ( $_POST ["FirstName"] ) );
		$LastName = mysqli_real_escape_string ( $dbc, trim ( $_POST ["LastName"] ) );
		$CountryCodeH = mysqli_real_escape_string ( $dbc, trim ( $_POST ["CountryCodeH"] ) );
		$LocalNumH = mysqli_real_escape_string ( $dbc, trim ( $_POST ["LocalNumH"] ) );
		$CountryCodeW = mysqli_real_escape_string ( $dbc, trim ( $_POST ["CountryCodeW"] ) );
		$LocalNumW = mysqli_real_escape_string ( $dbc, trim ( $_POST ["LocalNumW"] ) );
		$Address = mysqli_real_escape_string ( $dbc, trim ( $_POST ["Address"] ) );
		
                $query0 = "SELECT * FROM CUSTOMERS WHERE Email='$email' ";
                $result0 = mysqli_query ( $dbc, $query0 );
                
                
		if($password != $conf_password || $password == null){
			header ("Location : NewUser.html");
		}
                elseif (mysqli_num_rows($result0)>0) {
                                echo "You have already registered!";
				header("Location: Login.html"); 
				exit ();
                        }
                else {
                    $query1 = "INSERT INTO CUSTOMERS(email, password, FirstName, LastName, 
                                 CountryCodeW, LocalNumW,CountryCodeH, LocalNumH, Address) 
                                 VALUES ('$email', '$password', '$FirstName', '$LastName', "
                             . "'$CountryCodeW', '$LocalNumW','$CountryCodeH', '$LocalNumH', '$Address')";
                    if (mysqli_query($dbc, $query1)) {
                            echo "New record created successfully";
                             $_SESSION["email"]=$email;
                            header("Location: MakeReservation.html"); 
                            exit ();   
                        } 
                    else {
                           echo "Error: " . $query1 . "<br>" . mysqli_error($dbc);
                          }
                    
                     }
		
		/*if ($_POST ['user'] == "customer") {
			$query3 = "SELECT * FROM CUSTOMERS WHERE Email='$login' AND Password='$password'";
			$result3 = mysqli_query ( $dbc, $query3 );
			if (mysqli_num_rows($result3)>0) {
				header("Location: CustMainMenu.html");
				exit ();
			} else {
				header("Location: NewUser.html"); 
				exit ();
			}

		} */
                /*probably don't need this
                else if($_POST ['user'] == "clerk"){
			$query = "SELECT * FROM CLERK WHERE Email='$login' AND Password='$password'";
			$result = mysqli_query ( $dbc, $query );
			if (mysqli_num_rows($result)>0) {
				header ("Location: ClerkMainMenu.html");
			} else {
				echo "Clerk login error!";
				exit ();
			}
		}
                 * 
                 */
		/*else header ("Location: Login.html");*/
// 	}

	mysqli_close ( $dbc );
	
	?>
