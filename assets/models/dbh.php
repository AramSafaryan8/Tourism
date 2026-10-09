<?php
declare(strict_types = 1);

namespace Models;

use AppData\Config;
use Controllers\Errors as ErrorsController;

class Dbh
{
    private const REFERER_PREFIX_LENGTH = 24;
    protected $conn = NULL;
    protected $stmt = NULL;

    protected static function cast ($typeName, $value) {
        switch ($typeName) {
            case 'int':
                return (int)$value;
            case 'bool':
                return (bool)$value;
            case 'float':
                return (float)$value;
            case 'string':
                return (string)$value;
            case 'array':
                return explode(',', $value);
            
            default:
                return $value;
        }
    }

    public static function get_referer () : string {
        return explode('?', substr($_SERVER['HTTP_REFERER'], self::REFERER_PREFIX_LENGTH))[0];
    }

    protected function close () : void {
        (!empty($this->stmt)) && ($this->close_stmt());

        $this->conn = NULL;
    }

    protected function close_stmt () {
        $this->stmt = NULL;
    }
    
    protected function connect () : void {
        $db = Config::get_db();

        $options = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
        ];
        
        try {
            $this->conn = new \PDO($db->type . ':host=' . $db->host . ';dbname=' . $db->name, $db->username, $db->pwd, $options);
        } catch (\PDOException $e) {
            echo ErrorsController::index(['type' => 'dbconn', 'desc' => urlencode($e->getMessage())])->render();

            exit;
        }
    }

    protected function get (array $request) : array {
        if (empty($request)) {
            return [];
        }

        $result = new self();

        $result->connect();

        $sqlCondition = ' ';
        $keys = array_keys($request);
        $field = '';
        $length = count($keys);
        $bound = $length - 1;
        for ($i = 0; $i < $length; $i++) {
            $field = $keys[$i];
            
            $sqlCondition .= '`' . $field . '` = :' . $field;

            ($i < $bound) && ($sqlCondition .= ' AND ');
        }

        $resp = $result->prepare('SELECT * FROM `' . $this::TABLENAME . '` WHERE' . $sqlCondition, $request);

        $result->close();

        return $this->retrieve($resp);
    }

    protected function get_last_id () : int {
        return $conn->lastInsertId();
    }

    protected function prepare (string $query, array $params) : array {
        $this->stmt = $this->conn->prepare($query);

        foreach ($params as $key => $options) {
            $this->stmt->bindParam($key, $options['value'], $options['type']);
        }

        if (!$this->stmt->execute()) {
            $this->close();

            redirect('location: ', '/error?stmtfailed');
        }

        $result = $this->stmt->fetchAll();

        $this->close_stmt();

        return $result;
    }

    protected function query (string $query) : array {
        $this->stmt = $this->conn->query($query);
        
        $result = $this->stmt->fetchAll();

        $this->close_stmt();
        
        return $result;
    }
}