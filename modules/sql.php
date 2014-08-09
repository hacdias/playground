<?php

/**
 * SQL Class
 *
 * A class with static functions to make database queries.
 *
 * @author  Henrique Dias <me@henriquedias.com>
 * @package MathSpot
 * @subpackage SQL
 */

class Sql {

    /**
     * Do 'SELECT ? FROM ?'
     *
     * @param   array $options  Query settings.
     * @return  PDOStatement
     */
    static public function select($options = array()) {
        global $DATABASE;

        $query = $DATABASE->prepare('SELECT ? FROM ?');
        return $query->execute([
            $options['column'],
            $options['table']
        ]);
    }

    /**
     * Do 'SELECT * FROM ?'
     *
     * @param   array $options  Query settings.
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
     * Do "SELECT ? FROM ? WHERE ? = '?'"
     *
     * @param   array $options  Query settings.
     * @return  PDOStatement
     */
    static public function selectWhere($options = array()) {
        global $DATABASE;

        $query = "SELECT " . $options['column'] . " FROM " . $options['table'];
        $query .= " WHERE " .  $options['first'] . " = '" . $options['second'] . "'";

        return $DATABASE->query($query);
    }

    /**
     * Do "SELECT * FROM ? WHERE ? = '?'"
     *
     * @param   array $options  Query settings.
     * @return  PDOStatement
     */
    static public function selectAllWhere($options = array()) {
        global $DATABASE;

        $query = "SELECT * FROM " . $options['table'] . " WHERE ";
        $query .= $options['first'] . " = '" . $options['second'] . "'";

        return $DATABASE->query($query);
    }

    /**
     * Do 'SELECT ? FROM ? ORDER BY ?'
     *
     * @param   array $options  Query settings.
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
     * Do 'SELECT * FROM ? ORDER BY ?'
     *
     * @param   array $options  Query settings.
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
     * Do 'SELECT ? FROM ? LIMIT ?'
     *
     * @param   array $options  Query settings.
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
     * Do 'SELECT * FROM ? LIMIT ?'
     *
     * @param   array $options  Query settings.
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
     * Do 'SELECT ? FROM ? OFFSET ?'
     *
     * @param   array $options  Query settings.
     * @return  PDOStatement
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
     * Do 'SELECT * FROM ? OFFSET?'
     *
     * @param   array $options  Query settings.
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
     * Do 'SELECT ? FROM ? ORDER BY ? LIMIT ?'
     *
     * @param   array $options  Query settings.
     * @return  PDOStatement
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
     * Do 'SELECT ? FROM ? ORDER BY ? LIMIT ?'
     *
     * @param   array $options  Query settings.
     * @return  PDOStatement
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
     * @param   array $options  Query settings.
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
     * Do 'SELECT ? FROM ? ORDER BY ? LIMIT ? OFFSET ?'
     *
     * @param   array $options  Query settings.
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


    /** @todo See later */
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
