<?php

/*
 * Now it's time to process the info sent by the user.
 * We start collecting the info sent by POST method.
 */
$name = isset($_POST['name']) ? $_POST['name'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;

/**
 * Set the function that processes the info.
 *
 * @param	string $name		The name of the user
 * @param	string $password	The password of the user
 * @param	string $email		The email of the user
 */
function processInfo($name, $password, $email)
{
	//Set the response array.
	$result =  array();

	//Confirm if there is an empty parameter
	if (empty($name) || empty($password) || empty($email)) {

		/*
		 * If there is, we set the $result['status'] equal to false
		 * and prevent the continuing of the function returning the response.
		 */
		$result['status'] = false;
		return $result;
	}

	/*
	 * If all parameters are set, we connect to the database. In this example
	 * we use PDO and a SQLite database.
	 *
	 * TABLE STRUCTURE
	 *
	 * |--------------------------------|
	 * |  	NAME		|	DATA TYPE	|
	 * |----------------|---------------|
	 * | 	name		|	Text		|
	 * |	email		|	Text		|
	 * |	password	|	Text		|
	 * |________________________________|
	 */

	try {
		$db = new PDO('sqlite:db.sqlite');

		//We prepare the query string
		$query = "INSERT INTO users VALUES ('" . $name . "', '" . $email . "', '" . $password . "');";

		if($db->exec($query)) {
			//If the query is well executed, the status is defined to true
			$result['status'] = true;
		} else {
			//Else...
			$result['status'] = false;
		}

	} catch (PDOException $e) {
		$result['status'] = false;
	}

	return $result;
}

/**
 * Function to send the answer array to client-side.
 *
 * @param	array $response
 */
function sendInfoToAjax($response)
{
	//We set the header of content
	header('Content-type: application/json');
	//And "echo" the $response encoded in json
	echo json_encode($response);
}

//We process the info using the function above.
$result = processInfo($name, $password, $email);
sendInfoToAjax($result);
