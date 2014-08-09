<?php

/**
 * SQL CLASS
 *
 * A class with static functions to make database queries.
 *
 * @author 		Henrique Dias <me@henriquedias.com>
 * @package 	MathPocket
 * @subpackage	SQL
 */

require_once('config.php');

class Sql {

	/**
	 * Select one column from a table.
	 *
	 * @param	string $column	The name of the column.
	 * @param	string $table	The name of the table.
	 */
	static public function select($column, $table) {
		global $DATABASE;

		$query = $DATABASE->prepare("SELECT ? FROM ?");
		return $query->execute(array($column, $table));
	}

	/**
	 * Select all columns from a table.
	 *
	 * @param	string $table	The name of the table.
	 */
	static public function selectAll($table) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT * FROM ?');
		return $query->execute(array($table));
	}

	/**
	 * Select one $column from a $table where $first is equal
	 * to $second.
	 *
	 * @param	string $column	The name of the column.
	 * @param	string $table	The name of the table.
	 * @param	string $first	The name of the column to compare.
	 * @param	string $second	The content of the column $first.
	 */
	static public function selectWhere($column, $table, $first, $second) {
		global $DATABASE;

		$query = "SELECT " . $column . " FROM " . $table . " WHERE " .  $first . " = '" . $second . "'";
		return $DATABASE->query($query);
	}

	/**
	 * Select all columns from a $table where $first is equal
	 * to $second.
	 *
	 * @param	string $table	The name of the table.
	 * @param	string $first	The name of the column to compare.
	 * @param	string $second	The content of the column $first.
	 */
	static public function selectAllWhere($table, $first, $second) {
		global $DATABASE;

		$query = "SELECT * FROM " . $table . " WHERE " .  $first . " = '" . $second . "'";
		return $DATABASE->query($query);
	}

	/**
	 * Select one column from a table and order by something.
	 *
	 * @param	string $column		The name of the column to select.
	 * @param	string $table		The name of the table to execute the query.
	 * @param	string $something	Order the results by this.
	 */
	static public function selectOrder($column, $table, $something) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT ? FROM ? ORDER BY ?');
		return $query->execute(array($column, $table, $something));
	}

	/**
	 * Select all columns from a table and order by something.
	 *
	 * @param	string $table		The name of the table to execute the query.
	 * @param	string $something	Order the results by this.
	 */
	static public function selectAllOrder($table, $somthing) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT * FROM ? ORDER BY ?');
		return $query->execute(array($table, $something));
	}

	/**
	 * Select one column from a table and limit the number of rows.
	 *
	 * @param	string $column	The name of the column to select.
	 * @param	string $table	The name of the table to execute the query.
	 * @param	int $limit 		Itens limit number.
	 */
	static public function selectLimit($column, $table, $limit) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT ? FROM ? LIMIT ?');
		return $query->execute(array($column, $table, $limit));
	}

	/**
	 * Select all columns from a table and limit the number of rows.
	 *
	 * @param	string $table	The name of the table to execute the query.
	 * @param	int $limit 		Itens limit number.
	 */
	static public function selectAllLimit($table, $limit) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT * FROM ? LIMIT ?');
		return $query->execute(array($table, $limit));
	}

	/**
	 * Select one column from a table, limit the number of rows and setting an offset.
	 *
	 * @param	string $column	The name of the column to select.
	 * @param	string $table	The name of the table to execute the query.
	 * @param	int $limit 		Itens limit number.
	 * @param	int $offset		Offset.
	 */
	static public function selectLimitOffset($column, $table, $limit, $offset) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT ? FROM ? OFFSET ?');
		return $query->execute(array($column, $table, $limit, $offset));
	}

	/**
	 * Select all columsn from a table, limit the number of rows and setting an offset.
	 *
	 * @param	string $table	The name of the table to execute the query.
	 * @param	int $limit 		Itens limit number.
	 * @param	int $offset		Offset.
	 */
	static public function selectAllLimitOffset($table, $limit, $offset) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT * FROM ? LIMIT ? OFFSET ?');
		return $query->execute(array($table, $limit, $offset));
	}

	/**
	 * Select one column from a table with a rows limit and ordering the rows
	 * by something.
	 *
	 * @param
	 */
	static public function selectOrderLimit($what, $from, $order, $limit = 1) {
	global $DATABASE;

	$query = "SELECT " . $what . " FROM " . $from . " ORDER BY " . $order . " LIMIT " . $limit;
	return $DATABASE->query($query);
	}

	static public function selectOrderLimitOffset($what, $from, $order, $limit = 1, $offset = 0) {
	global $DATABASE;

	$query = "SELECT " . $what . " FROM " . $from . " ORDER BY " . $order . " LIMIT " . $limit . "," .  $offset;
	return $DATABASE->query($query);
	}

	static public function selectAllOrderLimit($from, $order, $limit = 1) {
	global $DATABASE;

	$query = "SELECT * FROM " . $from . " ORDER BY " . $order . " LIMIT " . $limit;
	return $DATABASE->query($query);
	}

	static public function selectALlOrderLimitOffset($from, $order, $limit = 1, $offset = 0) {
	global $DATABASE;

	$query = "SELECT * FROM " . $from . " ORDER BY " . $order . " LIMIT " . $limit . " OFFSET " .  $offset;
	return $DATABASE->query($query);
	}

	static public function selectAllOrderWhereLimitOffset($from, $where, $equalTo, $order, $limit = 1, $offset = 0) {
	global $DATABASE;

	$query = "SELECT * FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "' ORDER BY " . $order . " LIMIT " . $limit . " OFFSET " .  $offset;
	return $DATABASE->query($query);
	}

	static public function selectAllWhereMultipleOrder($from, $where, $equalTo, $order) {
	global $DATABASE;

	$query = "SELECT * FROM " . $from . " WHERE " . $where . " IN (" . $equalTo . ") ORDER BY " . $order;
	return $DATABASE->query($query);
	}

	static public function selectWhereLike($what, $from, $where, $like) {
	global $DATABASE;

	$query = "SELECT " . $what . " FROM " . $from . " WHERE " . $where . " LIKE '%". $like ."%'";
	return $DATABASE->query($query);
	}

	static public function selectAllWhereLike($from, $where, $like) {
	global $DATABASE;

	$query = "SELECT * FROM " . $from . " WHERE " . $where . " LIKE '%". $like ."%'";
	return $DATABASE->query($query);
	}

	static public function selectWhereLimit($what, $from, $where, $equalTo, $limit = 1) {
	global $DATABASE;

	$query = "SELECT " . $what . " FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "' LIMIT " . $limit;
	return $DATABASE->query($query);
	}

	static public function selectAllWhereLimit($from, $where, $equalTo, $limit = 1) {
	global $DATABASE;

	$query = "SELECT * FROM " . $from . " WHERE " . $where . " = '" . $equalTo . "' LIMIT " . $limit;
	return $DATABASE->query($query);
	}

	static public function updateOne($table, $what, $withWhat, $where, $whereWat) {
	global $DATABASE;

	$query = "UPDATE " . $table . "
	SET " . $what . " = '" . $withWhat . "'
	WHERE " . $where . " = '" . $whereWat . "';";

	return $DATABASE->query($query);
	}

	static public function rowNumber($table) {
	global $DATABASE;

	$result = $DATABASE->query("SELECT count(*) FROM " . $table);
	return $result->fetchColumn();

	}

	static public function rowNumberWhere($table, $where, $equalTo) {
	global $DATABASE;

	$result = $DATABASE->query("SELECT count(*) FROM " . $table . " WHERE " . $where . " = '" . $equalTo . "'");
	return $result->fetchColumn();

	}

}

?>
