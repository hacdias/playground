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

	static public function selectOneWhereLimit($what, $from, $where, $equalTo) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "' LIMIT 1";
		return $DATA['db']->query($query);
	}

	static public function selectAllWhereLimit($from, $where, $equalTo) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "' LIMIT 1";
		return $DATA['db']->query($query);
	}

	static public function updateOne($table, $what, $withWhat, $where, $whereWat) {
		global $DATA;

		$query = "UPDATE " . $table . "
				SET " . $what . " = '" . $withWhat . "'
				WHERE " . $where . " = '" . $whereWat . "';";

		return $DATA['db']->query($query);
	}

}

?>