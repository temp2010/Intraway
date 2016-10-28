<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PeopleDB
 *
 * @author daniel
 */
class StatusDB {
    protected $mysqli;
    const LOCALHOST = 'localhost';
    const USER      = 'root';
    const PASSWORD  = 'hamlet';
    const DATABASE  = 'status';

    public function __construct() {
        try {
            $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
        } catch (Exception $exc) {
            http_response_code(500);
            exit();
        }
    }
    
    public function getState($id=0) {
        if ($this->checkID($id)) {
            $stmt = $this->mysqli->prepare("SELECT id, email, DATE_FORMAT(create_at, '%Y-%m-%dT%TZ') AS create_at, status FROM status WHERE id = ?");
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result  = $stmt->get_result();
            $status = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $status;
        }
        return false;
    }
    
    public function getStatus($p, $r, $q) {        
        $stmt = $this->mysqli->prepare('SELECT * FROM status WHERE status LIKE ? LIMIT ?, ?');
        $stmt->bind_param('sii', $q, $p, $r);
        $stmt->execute();
        $result = $stmt->get_result();
        $status = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $status;
    }
    
    public function insert($status='', $email='annonymus') {
        $stmt = $this->mysqli->prepare("INSERT INTO status(email, status) VALUES (?, ?)");
        $stmt->bind_param('ss', $email, $status);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }
    
    public function delete($id=0) {
        $stmt = $this->mysqli->prepare("DELETE FROM people WHERE id = ?");
        $stmt->bind_param('i', $id);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }
    
    public function update($id, $newName) {
        if ($this->checkID($id)) {
            $stmt = $this->mysqli->prepare("UPDATE people SET name= ? WHERE id = ?");
            $stmt->bind_param('si', $newName, $id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
        return false;
    }
    
    public function checkID($id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM status WHERE id = ?");
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            $stmt->store_result();    
            if ($stmt->num_rows == 1) {                
                return true;
            }
        }        
        return false;
    }
}