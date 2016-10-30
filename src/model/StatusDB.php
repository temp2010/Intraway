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

    /**
     * class constructor.
     * Make the Connection
     */
    public function __construct() {
        try {
            $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
        } catch (Exception $exc) {
            http_response_code(500);
            exit();
        }
    }
    
    /**
     * Gets a state
     * @param integer $id id of table status
     * @return array state
     */
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
    
    /**
     * Gets a states
     * @param integer $p page
     * @param integer $r rows
     * @param string $q search
     * @return array status
     */
    public function getStatus($p, $r, $q) {        
        $stmt = $this->mysqli->prepare('SELECT * FROM status WHERE status LIKE ? LIMIT ?, ?');
        $stmt->bind_param('sii', $q, $p, $r);
        $stmt->execute();
        $result = $stmt->get_result();
        $status = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $status;
    }
    
    /**
     * Insert in status
     * @param string $status status insert
     * @param email  $email email insert
     * @return boolean
     */
    public function insert($status='', $email='annonymus') {
        $stmt = $this->mysqli->prepare("INSERT INTO status(email, status) VALUES (?, ?)");
        $stmt->bind_param('ss', $email, $status);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }
    
    /**
     * Delete status
     * @param code  id md5
     * @return boolean
     */
    public function delete($code='') {
        $stmt = $this->mysqli->prepare("DELETE FROM status WHERE md5(id) = ?");
        $stmt->bind_param('s', $code);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function checkID($id, $mail = false) {
        $where = "";
        if ($mail) {
            $where = "AND email != 'annonymus'";
        }
        $stmt = $this->mysqli->prepare("SELECT * FROM status WHERE id = ? $where");
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            $stmt->store_result();    
            if ($stmt->num_rows == 1) {                
                return true;
            }
        }        
        return false;
    }
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function checkCODE($code) {
        $stmt = $this->mysqli->prepare("SELECT * FROM status WHERE md5(id) = ?");
        $stmt->bind_param("s", $code);
        if ($stmt->execute()) {
            $stmt->store_result();    
            if ($stmt->num_rows == 1) {                
                return true;
            }
        }        
        return false;
    }
}