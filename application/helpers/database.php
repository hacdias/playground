<?php

namespace Helpers;

use \PDO;

/**
* Database Class
*
* This is the base class for every database connection and
* it contains some shortcuts.
*
* @package     InMVC
* @subpackage  Core
*/
class Database extends PDO
{
    /**
    * Constructor
    *
    * This function establish the connection to the database
    * with the data provided.
    *
    * @param string $DB_TYPE The type of the database.
    * @param string $DB_HOST Where is the database hosted.
    * @param string $DB_NAME The name of the database.
    * @param string $DB_USER The username to access the database.
    * @param string $DB_PASS The password used to login.
    */
    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    {
        try {
            parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS);
            $this->exec("SET NAMES 'utf8';");
        } catch (\PDOException $e) {
            error_log($e->getMessage());

            $error = new \Controllers\Error;
            $error->index('500');

            die();
        }

    }

    /**
    * Select Function
    *
    * This function is a shortcut for the SELECT command
    * of the database and has some other benefits.
    *
    * @param string $sql The SQL command.
    * @param array $array Parameters to bind
    * @param int $fetchMode A PDO Fetch mode
    *
    * @return array
    */
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $sth = $this->prepare($sql);

        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        $sth->execute();

        $data = $sth->fetchAll($fetchMode);

        return $data;
    }

    /**
    * Insert Function
    *
    * Function used to insert things in the database.
    *
    * @param string $table A name of table to insert into.
    * @param string $data An associative array.
    */
    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        if (!$sth->execute()) {
            error_log('Problem');
            $error = new \Controllers\Error;
            $error->index('500');
            die();
        }
    }

    /**
    * Update Function
    *
    * Function used to update things on the database.
    *
    * @param string $table A name of table to insert into
    * @param string $data An associative array
    * @param string $where the WHERE query part
    */
    public function update($table, $data, $where)
    {
        ksort($data);
        $fieldDetails = NULL;

        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }

        $fieldDetails = rtrim($fieldDetails, ',');

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        if (!$sth->execute()) {
            $error = new \Controllers\Error;
            $error->index('500');
            die();
        }
    }

    /**
    * Delete Function
    *
    * Function used to delete things from the database.
    *
    * @param string $table
    * @param string $where
    * @param integer $limit
    * @return integer Affected Rows
    */
    public function delete($table, $where, $limit = 1)
    {
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }

}
