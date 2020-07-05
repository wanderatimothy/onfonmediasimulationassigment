<?php
class DB
{
    // connects to the database
    public $connect;
    // contains the errors  incase of the failed execution
    public $Errors;

    // contains the PDO statement for futher manipulation such as getting results
    public $results;

    // PDO connection 

    function __construct()
    {
        $this->connect = new PDO("mysql:host=localhost;dbname=onfonsimulation;", 'root', '');
    }

    // Run any query with parameters

    function runQuery(string $sql, array $params)
    {
        $this->__construct();

        $trace = $this->connect->prepare($sql);
        // checks if  prepare function didnt return a boolean false
        if ($trace != false) {
            if ($trace->execute($params)) {
                $this->results = $trace;
                return true;
            } else {
                $this->Errors = $trace->errorInfo();
                return false;
            };
        } else {
            return false;
        }
    }

    // run query qith no parameters

    function Query(string $sql)
    {
        $this->__construct();
        $trace = $this->connect->query($sql);
        if ($trace != false) {

            $this->results = $trace;
            return true;
        } else {
            $this->Errors = "Please check your query";
            return false;
        }
    }
}
