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

class Sql {

	/**
	 * Select one column from a table.
	 *
	 * @param   array $options    The list of options
     * @return  PDOStatement
	 */
	static public function select($options = array()) {
		global $DATABASE;

		$query = $DATABASE->prepare("SELECT ? FROM ?");
		return $query->execute([
            $options['column'],
            $options['table']
        ]);
	}

	/**
	 * Select all columns from a table.
	 *
	 * @param   array $options  The list of options
     * @return  PDOStatement
	 */
	static public function selectAll($options = array()) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT * FROM ?');
		return $query->execute([
            $options['table']
        ]);
	}

	/**
	 * Select one $column from a $table where $first is equal
	 * to $second.
	 *
	 * @param   array $options The list of options
     * @return  PDOStatement
	 */
	static public function selectWhere($options = array()) {
		global $DATABASE;

		$query = "SELECT " . $options['column'] . " FROM " . $options['table'];
		$query .= " WHERE " .  $options['first'] . " = '" . $options['second'] . "'";

		return $DATABASE->query($query);
	}

	/**
	 * Select all columns from a $table where $first is equal
	 * to $second.
	 *
	 * @param   array $options  The list of options
     * @return  PDOStatement
	 */
	static public function selectAllWhere($options = array()) {
		global $DATABASE;

		$query = "SELECT * FROM " . $options['table'] . " WHERE ";
		$query .= $options['first'] . " = '" . $options['second'] . "'";

		return $DATABASE->query($query);
	}

	/**
	 * Select one column from a table and order by something.
	 *
	 * @param   array $options  The list of options
     * @return  PDOStatement
	 */
	static public function selectOrder($options = array()) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT ? FROM ? ORDER BY ?');
		return $query->execute([
            $options['column'],
			$options['table'],
			$options['something']
        ]);
	}

	/**
	 * Select all columns from a table and order by something.
	 *
	 * @param   array $options  The list of options
     * @return  PDOStatement
	 */
	static public function selectAllOrder($options = array()) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT * FROM ? ORDER BY ?');
		return $query->execute([
            $options['table'],
			$options['something']
        ]);
	}

	/**
	 * Select one column from a table and limit the number of rows.
	 *
	 * @param   array $options  The list of options
     * @return  PDOStatement
	 */
	static public function selectLimit($options = array()) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT ? FROM ? LIMIT ?');
		return $query->execute([
            $options['column'],
			$options['table'],
			$options['limit']
        ]);
	}

	/**
	 * Select all columns from a table and limit the number of rows.
	 *
	 * @param   array $options  The list of options
     * @return  PDOStatement
	 */
	static public function selectAllLimit($options = array()) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT * FROM ? LIMIT ?');
		return $query->execute([
            $options['table'],
			$options['limit']
        ]);
	}

    /**
     * Select one column from a table, limit the number of rows and setting an offset.
     *
     * @param   array $options The name of the column to select.
     * @return  The query.
     */
	static public function selectLimitOffset($options = array()) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT ? FROM ? OFFSET ?');
		return $query->execute([
            $options['column'],
            $options['table'],
            $options['limit'],
            $options['offset']
        ]);
	}

	/**
	 * Select all column from a table, limit the number of rows and setting an offset.
	 *
	 * @param   array $options  The list of options
     * @return  PDOStatement
	 */
	static public function selectAllLimitOffset($options = array()) {
		global $DATABASE;

		$query = $DATABASE->prepare('SELECT * FROM ? LIMIT ? OFFSET ?');
		return $query->execute([
            $options['table'],
            $options['limit'],
            $options['offset']
        ]);
	}

    /**
     * Select one column from a table with a rows limit and ordering the rows
     * by something.
     *
     * @param array $options    The list of options
     * @return PDOStatement
     */
	static public function selectOrderLimit($options = array()) {
        global $DATABASE;

        $query = $DATABASE->prepare('SELECT ? FROM ? ORDER BY ? LIMIT ?');
        return $query->execute([
            $options['what'],
            $options['table'],
            $options['order'],
            $options['limit']
        ]);
	}

    /**
     * Do the query: SELECT ? FROM ? ORDER BY ? LIMIT ?,?
     *
     * @param   array $options  The list of options
     * @return  PDO Statement
     */
    static public function selectOrderLimitOffset($options = array()) {
        global $DATABASE;

        $options['limit'] = isset($options['limit']) ? $options['limit'] : 1;

        $query = $DATABASE->prepare('SELECT ? FROM ? ORDER BY ? LIMIT ?,?');
        return $query->execute([
            $options['what'],
            $options['from'],
            $options['order'],
            $options['limit'],
            $options['offset']
        ]);
	}

    /**
     * Do 'SELECT * FROM ? ORDER BY ? LIMIT ?'
     *
     * @param   array $options  The list of options
     * @return  PDOStatement
     */
    static public function selectAllOrderLimit($options = array()) {
        global $DATABASE;

        $options['limit'] = isset($options['limit']) ? $options['limit'] : 1;

        $query = $DATABASE->prepare('SELECT * FROM ? ORDER BY ? LIMIT ?');
        return $query->execute([
            $options['from'],
            $options['order'],
            $options['limit']
        ]);
	}

    /**
     * Do 'SELECT * FROM ? ORDER BY ? LIMIT ? OFFSET ?'
     *
     * @param   array $options    The list of options
     * @return  PDOStatement
     */
    static public function selectALlOrderLimitOffset($options = array()) {
        global $DATABASE;

        $options['limit'] = isset($options['limit']) ? $options['limit'] : 1;
        $options['offset'] = isset($options['offset']) ? $options['offset'] : 0;

        $query = $DATABASE->prepare('SELECT * FROM ? ORDER BY ? LIMIT ? OFFSET ?');
        return $query->execute([
            $options['from'],
            $options['order'],
            $options['limit'],
            $options['offset']
        ]);
	}

    /**
     * Do "SELECT * FROM ? WHERE ? = '?' ORDER BY ? LIMIT ? OFFSET ?"
     *
     * @param   array $options  Query settings.
     * @return  PDOStatement
     */
    static public function selectAllOrderWhereLimitOffset($options = array()) {
        global $DATABASE;

        $options['limit'] = isset($options['limit']) ? $options['limit'] : 1;
        $options['offset'] = isset($options['offset']) ? $options['offset'] : 0;

        $query = $DATABASE->prepare("SELECT * FROM ? WHERE ? = '?' ORDER BY ? LIMIT ? OFFSET ?");
        return $query->execute([
            $options['from'],
            $options['where'],
            $options['equalTo'],
            $options['order'],
            $options['limit'],
            $options['offset']
        ]);
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
