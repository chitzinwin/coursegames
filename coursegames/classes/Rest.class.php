<?php
require_once 'HTTP/Request2.php';
//require_once 'classes/Availability.class.php';
require_once 'classes/Constants.class.php';
//require_once 'classes/Contact.class.php';
//require_once 'classes/Name.class.php';

class Rest {

	public $constants = '';
	public $clientURL = '';

	function __construct($clientURL)
	{
		$this->clientURL=$clientURL;
	}
	
	public function authorize() {
		
		$constants = new Constants($this->clientURL);
		$token = new Token();
		
		$request = new HTTP_Request2($constants->HOSTNAME . $constants->AUTH_PATH, HTTP_Request2::METHOD_POST);
		$request->setAuth($constants->KEY, $constants->SECRET, HTTP_Request2::AUTH_BASIC);
		$request->setBody('grant_type=client_credentials');
		$request->setHeader('Content-Type', 'application/x-www-form-urlencoded');
                        $request->setConfig(array(
                                'ssl_verify_peer'   => $constants->ssl_verify_peer,
                                'ssl_verify_host'   => $constants->ssl_verify_host
                        ));

		
		
		try {
			$response = $request->send();
			if (200 == $response->getStatus()) {
				//print " Authorize Application...\n";
				$token = json_decode($response->getBody());
			} else {
				print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
						$response->getReasonPhrase();
				$BbRestException = json_decode($response->getBody());
				var_dump($BbRestException);
			}
		} catch (HTTP_Request2_Exception $e) {
			print 'Error: ' . $e->getMessage();
		}
		
		return $token;
	}
	
		public function readCourse($access_token, $course_id) {
			$constants = new Constants($this->clientURL);
			$course = new Course();
		
			$request = new HTTP_Request2($constants->HOSTNAME . $constants->COURSE_PATH . '/' . $course_id, HTTP_Request2::METHOD_GET);
			$request->setHeader('Authorization', 'Bearer ' . $access_token);
                        $request->setConfig(array(
                                'ssl_verify_peer'   => $constants->ssl_verify_peer,
                                'ssl_verify_host'   => $constants->ssl_verify_host
                        ));

		
			try {
				$response = $request->send();
				if (200 == $response->getStatus()) {
					print "\n Read Course...\n";
					$course = json_decode($response->getBody());
				} else {
					print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
							$response->getReasonPhrase();
							$BbRestException = json_decode($response->getBody());
							var_dump($BbRestException);
				}
			} catch (HTTP_Request2_Exception $e) {
				print 'Error: ' . $e->getMessage();
			}
		
			return $course;
		}
		
		
		public function readUser($access_token, $user_id) {
			$constants = new Constants($this->clientURL);
			//$user = new User();
		
			$request = new HTTP_Request2($constants->HOSTNAME . $constants->USER_PATH . '/' . $user_id, HTTP_Request2::METHOD_GET);
			$request->setHeader('Authorization', 'Bearer ' . $access_token);
                        $request->setConfig(array(
                                'ssl_verify_peer'   => $constants->ssl_verify_peer,
                                'ssl_verify_host'   => $constants->ssl_verify_host
                        ));

		
			try {
				$response = $request->send();
				if (200 == $response->getStatus()) {
					//print "\n Read User...\n";
					$user = json_decode($response->getBody());
				} else {
					print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
							$response->getReasonPhrase();
							$BbRestException = json_decode($response->getBody());
							var_dump($BbRestException);
				}
			} catch (HTTP_Request2_Exception $e) {
				print 'Error: ' . $e->getMessage();
			}
		
			return $user;
		}
		
		
		public function readMembership($access_token, $course_id, $user_id) {
			$constants = new Constants($this->clientURL);
			//$membership = new Membership();
		
			$request = new HTTP_Request2($constants->HOSTNAME . $constants->COURSE_PATH . '/' . $course_id . '/users/' . $user_id,  HTTP_Request2::METHOD_GET);
			//$request = new HTTP_Request2($constants->HOSTNAME . $constants->COURSE_PATH . '/' . $course_id . '/users/' . $user_id,  HTTP_Request2::METHOD_GET);
			$request->setHeader('Authorization', 'Bearer ' . $access_token);
                        $request->setConfig(array(
                                'ssl_verify_peer'   => $constants->ssl_verify_peer,
                                'ssl_verify_host'   => $constants->ssl_verify_host
                        ));

		
			try {
				$response = $request->send();
				if (200 == $response->getStatus()) {
	//				print "\n Read Membership...\n";
					$membership = json_decode($response->getBody());
				} else {
					print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
							$response->getReasonPhrase();
							$BbRestException = json_decode($response->getBody());
							var_dump($BbRestException);
				}
			} catch (HTTP_Request2_Exception $e) {
				print 'Error: ' . $e->getMessage();
			}
		
			return $membership;
		}

                public function readGradebookColumns($access_token, $course_id) {
                        $constants = new Constants($this->clientURL);
                        //$GradebookColumns = new GradebookColumns();

                        $request = new HTTP_Request2($constants->HOSTNAME . $constants->COURSE_PATH . '/' . $course_id . '/gradebook/columns', HTTP_Request2::METHOD_GET);
                        $request->setHeader('Authorization', 'Bearer ' . $access_token);
                        $request->setConfig(array(
                                'ssl_verify_peer'   => $constants->ssl_verify_peer,
                                'ssl_verify_host'   => $constants->ssl_verify_host
                        ));


                        try {
                                $response = $request->send();
                                if (200 == $response->getStatus()) {

                                        $GradebookColumns = json_decode($response->getBody());
                                } else {
                                        print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                                                        $response->getReasonPhrase();
                                                        $BbRestException = json_decode($response->getBody());
                                                        var_dump($BbRestException);
                                }
                        } catch (HTTP_Request2_Exception $e) {
                                print 'Error: ' . $e->getMessage();
                        }

                        return $GradebookColumns;
                }
		
                public function readGradebookGrades($access_token, $course_id, $column_id) {
                        $constants = new Constants($this->clientURL);
                        //$GradebookGrades = new GradebookGrades();

                        $request = new HTTP_Request2($constants->HOSTNAME . $constants->COURSE_PATH . '/' . $course_id . '/gradebook/columns/' . $column_id . '/users', HTTP_Request2::METHOD_GET);

                        $request->setHeader('Authorization', 'Bearer ' . $access_token);
                        $request->setConfig(array(
                                'ssl_verify_peer'   => $constants->ssl_verify_peer,
                                'ssl_verify_host'   => $constants->ssl_verify_host
                        ));


                        try {
                                $response = $request->send();
                                if (200 == $response->getStatus()) {

                                        $GradebookGrades = json_decode($response->getBody());
                                } else {
                                        print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                                                        $response->getReasonPhrase();
                                                        $BbRestException = json_decode($response->getBody());
                                                        var_dump($BbRestException);
                                }
                        } catch (HTTP_Request2_Exception $e) {
                                print 'Error: ' . $e->getMessage();
                        }

                        return $GradebookGrades;
                }
}
?>
