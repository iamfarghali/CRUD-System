<?php

include('db_connection.php');

// Validator
function validate($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}


// insert function 
if (! function_exists('insert')) {
	function insert( string $tbl_name, array $colAndVal) {
		$bindParams = [];
		$query = 'INSERT INTO '.$tbl_name.' ( ';
		foreach ($colAndVal as $col => $val) {
			$query .= $col.', ';
		}
		$query = rtrim($query, ", ");
		$query .= ') VALUES (';
		foreach ($colAndVal as $col => $val) {
			$bindParams[':'.$col] = $val;
			$query .= ':'.$col.', ';
		}
		$query = rtrim($query, ", ");
		$query .= ')';
		$stmt = $GLOBALS['dbConn']->prepare($query);
		$stmt->execute($bindParams);
		if ($stmt->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
}

/** 
 * selectDataFrom function
 * @param $tbl_name string
 * @return array table's data
*/ 
if (! function_exists('selectDataFrom')) {
	function selectDataFrom( string $tbl_name) {
		$query = 'SELECT * FROM '.$tbl_name;
		$stmt = $GLOBALS['dbConn']->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		if (! empty($data)) {
			return $data;
		} else {
			return 'There is no data till now.';
		}
	}
}

/** 
 * selectRowFrom function
 * @param $tbl_name string
 * @param $user_id string
 * @return array row's data
*/ 
if (! function_exists('selectRowFrom')) {
	function selectRowFrom( string $tbl_name, string $idColName, string $idColVal) {
		$query = 'SELECT * FROM '.$tbl_name.' WHERE '.$idColName.' = ?';
		$stmt = $GLOBALS['dbConn']->prepare($query);
		$stmt->execute([$idColVal]);
		$data = $stmt->fetch();
		if (! empty($data)) {
			return $data;
		} else {
			return 'There is no data till now.';
		}
	}
}


/**
 * deleteRow function
 * @param $tbl_name string
 * @param $idColName string
 * @param $idColVal string
 * @return  boolean
 */
if (!function_exists('deleteRow')) {
	function deleteRow(string $tbl_name, string $idColName, string $idColVal) {
		$query = 'DELETE FROM '.$tbl_name.' WHERE '.$idColName.' = ?';
		$stmt = $GLOBALS['dbConn']->prepare($query);
		$stmt->execute([$idColVal]);
		if ($stmt->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
}


// update function 
if (! function_exists('update')) {
	function update( string $tbl_name, array $colAndVal, string $user_id) {
		$bindParams = [];
		$bindParams['user_id'] = !empty($user_id) ? $user_id : null;

		$query = 'UPDATE '.$tbl_name.' SET ';
		foreach ($colAndVal as $col => $val) {
			$bindParams[$col] = $val;
			$query .= $col.' = :'.$col.', ';
		}
		$query = rtrim($query, ", ");
		$query .= ' WHERE user_id=:user_id';
		
		$stmt = $GLOBALS['dbConn']->prepare($query);
		$stmt->execute($bindParams);
		if ($stmt->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
}

// Select Orders with its Owners 

if (!function_exists('selectOrders')) {
	function selectOrders() {
		$query = 'SELECT u.full_name as owner, o.* FROM orders o LEFT JOIN user u ON o.user_id = u.user_id';
		$stmt = $GLOBALS['dbConn']->prepare($query);
		$stmt->execute();
		if ( $stmt->rowCount() > 0) {
			return $stmt->fetchAll();
		} else {
			return 'There is no data.';
		}
	}
}

?>