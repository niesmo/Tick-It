<?php
/**
 * Created by PhpStorm.
 * User: Niesmo
 * Date: 10/18/14
 * Time: 4:21 PM
 */

/*
  Copyright (c) 2013 Nima Esmaili Mokaram

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
*/


class Database {
    private $lastResult;
    private $connection;
    private $debug = false;
    private $error = false;

    public function __construct($host, $user, $pass, $db) {
        $this->lastResult = NULL;
        $this->connection = new mysqli ( $host, $user, $pass, $db ) or die ( 'HOST ERROR.' );
        mysqli_select_db ( $this->connection, $db ) or die ( 'DATABASE ERROR.' );
    }

    public function isConnected() {
        return $this->connection;
    }

    public function error_on(){
        $this->error = true;
    }
    public function error_off(){
        $this->error = false;
    }

    public function debug_on(){
        $this->debug = true;
    }
    public function debug_off(){
        $this->debug = false;
    }

    public function query($query) {
        if($this->debug)
            echo $query . "<br>";
        $this->lastResult = mysqli_query ( $this->connection, $query );
        if ($this->lastResult == false && $this->error)
            echo "$query is a BAD QUERY!!!";
        return $this->lastResult;
    }

    public function escapeBadChars($str){
        return mysqli_real_escape_string ($this->connection , (string)$str);

    }

    public function insert($tableName, $columns, $values, $where = "") {
        $q = "INSERT INTO $tableName ($columns) VALUES ($values)";
        if ($where != "")
            $q .= "WHERE $where";

        if($this->debug)
            echo $q . "<br>";
        $this->query ( $q );
        if(mysqli_affected_rows ( $this->connection ) != -1)
            return true;
        return false;
    }

    public function delete($tableName, $where = "") {
        $q = "DELETE FROM $tableName WHERE $where";
        if($this->debug)
            echo $q . "<br>";
        $this->query ( $q );
        if(mysqli_affected_rows ( $this->connection ) != -1)
            return true;
        return false;
    }

    public function update($tableName, $set, $where="")
    {
        $q = "UPDATE $tableName SET $set WHERE $where";
        if($this->debug)
            echo $q . "<br>";
        $this->query ( $q );
        if(mysqli_affected_rows ( $this->connection ) != -1)
            return true;
        return false;
    }

    public function select($tablesNames = "", $fields = "", $where = "", $groupby = "" , $sortby = "", $limit = "" ) {
        $q = "SELECT " . ($fields == "" ? "*" : "$fields ") . ($tablesNames == "" ? "" : "FROM $tablesNames ") . ($where == "" ? "" : "WHERE $where ") . ($groupby == "" ? "" : " GROUP BY $groupby ") . ($sortby == "" ? "" : " ORDER BY $sortby ") . ($limit == "" ? "" : " LIMIT $limit ") ;
        if($this->debug)
            echo $q . "<br>";

        $this->query ($q);
        while ( $entry = $this->fetchNextObject () )
            $a [] = $entry;
        return $a;
    }

    public function fetchNextObject($result = NULL) {
        if ($result == NULL)
            $result = $this->lastResult;

        if ($result == NULL || mysqli_num_rows ( $result ) < 1)
            return NULL;
        else
            return mysqli_fetch_assoc($result);
    }

    public function affectedRows($result = NULL) {
        if ($result == NULL)
            return mysqli_affected_rows();
        return mysqli_affected_rows();
    }


    public function numRows($result = NULL) {
        if ($result == NULL)
            return mysqli_num_rows ( $this->lastResult );
        else
            return mysqli_num_rows ( $result );
    }

    public function lastInsertedId() {
        return mysqli_insert_id ($this->connection);
    }

    public function __destruct() {
        mysqli_close ($this->connection);
        $this->connection = FALSE;
    }
}
?>