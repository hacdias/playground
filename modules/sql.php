<?php

/**
 * SQL CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class sql {

	static public function selectOne($what, $from) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from;
		return $DATA['db']->query($query);
	}

	static public function selectAll($from) {
		global $DATA;

		$query = "SELECT * FROM " . $from;
		return $DATA['db']->query($query);
	}

	static public function selectOneOrder($what, $from, $order) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " ORDER BY " . $order;
		return $DATA['db']->query($query);
	}

	static public function selectAllOrder($from, $order) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " ORDER BY " . $order;
		return $DATA['db']->query($query);
	}

	static public function selectOneOrderLimit($what, $from, $order, $limit = 1) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " ORDER BY " . $order . " LIMIT " . $limit;
		return $DATA['db']->query($query);
	}

	static public function selectOneOrderLimitOffset($what, $from, $order, $limit = 1, $offset = 0) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " ORDER BY " . $order . " LIMIT " . $limit . "," .  $offset;
		return $DATA['db']->query($query);
	}

	static public function selectAllOrderLimit($from, $order, $limit = 1) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " ORDER BY " . $order . " LIMIT " . $limit;
		return $DATA['db']->query($query);
	}

	static public function selectALlOrderLimitOffset($from, $order, $limit = 1, $offset = 0) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " ORDER BY " . $order . " LIMIT " . $limit . " OFFSET " .  $offset;
		return $DATA['db']->query($query);
		
	}

	static public function selectOneWhere($what, $from, $where, $equalTo) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "'";
		return $DATA['db']->query($query);
	}

	static public function selectAllWhere($from, $where, $equalTo) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "'";
		return $DATA['db']->query($query);
	}

	static public function selectOneWhereLike($what, $from, $where, $like) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " WHERE " . $where . " LIKE '%". $like ."%'";
		return $DATA['db']->query($query);
	}

	static public function selectAllWhereLike($from, $where, $like) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " WHERE " . $where . " LIKE '%". $like ."%'";
		return $DATA['db']->query($query);
	}

	static public function selectOneWhereLimit($what, $from, $where, $equalTo, $limit = 1) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "' LIMIT " . $limit;
		return $DATA['db']->query($query);
	}

	static public function selectAllWhereLimit($from, $where, $equalTo, $limit = 1) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "' LIMIT " . $limit;
		return $DATA['db']->query($query);
	}

	static public function updateOne($table, $what, $withWhat, $where, $whereWat) {
		global $DATA;

		$query = "UPDATE " . $table . "
				SET " . $what . " = '" . $withWhat . "'
				WHERE " . $where . " = '" . $whereWat . "';";

		return $DATA['db']->query($query);
	}

	static public function rowNumber($table) {
		global $DATA;

		$result = $DATA['db']->query("SELECT count(*) FROM " . $table); 
		return $result->fetchColumn(); 

	}

	static public function rowNumberWhere($table, $where, $equalTo) {
		global $DATA;

		$result = $DATA['db']->query("SELECT count(*) FROM " . $table . " WHERE " . $where . " = '" . $equalTo . "'"); 
		return $result->fetchColumn(); 

	}

}

?>