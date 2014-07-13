<?php

/**
 * SQL CLASS
 *
 * @author Henrique Dias
 * @package CodePocket
 */

require_once('config.php');

class sql {

	public function selectOne($what, $from) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from;
		return $DATA['db']->query($query);
	}

	public function selectAll($from) {
		global $DATA;

		$query = "SELECT * FROM " . $from;
		return $DATA['db']->query($query);
	}

	public function selectOneWhere($what, $from, $where, $equalTo) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "'";
		return $DATA['db']->query($query);
	}

	public function selectAllWhere($from, $where, $equalTo) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "'";
		return $DATA['db']->query($query);
	}

	public function selectOneWhereLike($what, $from, $where, $like) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " WHERE " . $where . " LIKE '%". $like ."%'";
		return $DATA['db']->query($query);
	}

	public function selectAllWhereLike($from, $where, $like) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " WHERE " . $where . " LIKE '%". $like ."%'";
		return $DATA['db']->query($query);
	}

	public function selectOneWhereLimit($what, $from, $where, $equalTo) {
		global $DATA;

		$query = "SELECT " . $what . " FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "' LIMIT 1";
		return $DATA['db']->query($query);
	}

	public function selectAllWhereLimit($from, $where, $equalTo) {
		global $DATA;

		$query = "SELECT * FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "' LIMIT 1";
		return $DATA['db']->query($query);
	}

	public function updateOne($table, $what, $withWhat, $where, $whereWat) {
		global $DATA;

		$query = "UPDATE " . $table . "
				SET " . $what . " = '" . $withWhat . "'
				WHERE " . $where . " = '" . $whereWat . "';";

		return $DATA['db']->query($query);
	}

}

?>