<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';
require_once 'dbconfig.php';

class USER
{	





	/*
	 * Register new User
	 *
	 */
	public function register($name,$password) {
		try {
			$password = md5($password);
			$db = new Database();
			$db->connect();
			$sql = "INSERT INTO users(name,password)
					VALUES(:name,:password)";
			
			$params = array(":name" => $name,
							":password" => $password
							);
			$i = $db->runUpdate($sql,$params);
		} catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}
	
	/*
	 * Login function
	 *
	 */
	public function login($name,$password) {
		$datarow = NULL;
		try
		{
			$db = new Database();
			$db->connect();
			
			$sql = "SELECT * FROM users WHERE name= :name and password= :password";
			$params = array(
						":name" => $name,
						":password"  => md5($password));
			$results = $db->runSelect($sql,$params);
			
			if ($results != null){
				$datarow = $results[0];
			}		
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
		return $datarow;
	}
	
	/*
	 * Check if email address exists already
	 *
	 */
	public function nameExists($name) {
		$result = false;
		try
		{
			$db = new Database();
			$db->connect();
			$sql = "SELECT name FROM users WHERE name= :name limit 1";
			$params = array(":name" => $name);
			$rs = $db->runSelect($sql,$params);
			
			if ($rs != null){
				$result = true;
			}
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
		return $result;
	}

	/*
	 * Check if email exists
	 *
	 */
	public function emailCheck($email) {
		$result = false;
		try
		{
			$db = new Database();
			$db->connect();
			$sql = "SELECT userEmail FROM tbl_users WHERE userEmail= :uemail limit 1";
			$params = array(":uemail" => $email);
			$rs = $db->runSelect($sql,$params);
			
			if ($rs != null){
				$result = true;
			}
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
		return $result;
	}



	/*
	 * Forgot Password
	 *
	 */

	public function forgotPass($email,$code) {
		try {
			$db = new Database();
			$db->connect();
			$sql = "UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:user_mail";
			
			$params = array(":user_mail" => $email,
							":token" => $code);
			$i = $db->runUpdate($sql,$params);

			$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
		    //Server settings
		    //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'rmagezi@intervas.com';                 // SMTP username
		    $mail->Password = '<tywan256/>';                           // SMTP password
		    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 587;                                    // TCP port to connect to

		    //Recipients
		    $mail->setFrom('rmagezi@intervas.com', 'MTN Shortz Uganda');
		    $mail->addAddress($email);     // Add a recipient
		    // Optional name

		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Reset Password';
		    $mail->Body    = "
		                               Hello , $email
		                               
		                               We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore this email,
		                               
		                               Click Following Link To Reset Your Password 
		                               
		                               http://www.contentconnectafrica.com/ug/resetpass.php?email=$email&code=$code
		                               
		                               thank you :)
		                               ";
		    $mail->AltBody = 'mail clients';

		    $mail->send();

		} catch (Exception $e) {

		}

		} catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}





	/*
	 * Check code
	 *
	 */
	public function codeCheck($email,$token) {
		$result = false;
		try
		{
			$db = new Database();
			$db->connect();
			$sql = "SELECT * FROM tbl_users WHERE userEmail=:uemail AND tokenCode=:token";
			$params = array(":uemail" => $email,":token" => $token);
			$rs = $db->runSelect($sql,$params);
			
			if ($rs != null){
				$result = true;
			}
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
		return $result;
	}



    /*
	 * Reset Password
	 *
	 */
	public function resetPass($email,$password) {
		try {
			$db = new Database();
			$db->connect();
			$sql = "UPDATE tbl_users SET userPass=:password WHERE userEmail=:user_mail";
			
			$params = array(":user_mail" => $email,
							":password" => $password);
			$i = $db->runUpdate($sql,$params);
		} catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}


}

?>
