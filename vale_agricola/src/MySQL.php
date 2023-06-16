<?php

require_once "Config.php";

class MySQL{
    
    private $connection;

    public function __construct()
    {
        $this->connection = new \mysqli(HOST, USER, PASSWORD, DATABASE);
        $this->connection->set_charset("utf8mb4");
    }

    public function execute($sql, $params = []): bool
    {
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt === false) {
            // Tratar erro de preparação da consulta
            return false;
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }
    
    public function query($sql, $params = []): array
    {
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt === false) {
            // Tratar erro de preparação da consulta
            return [];
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        
        return $data;
    }
}
