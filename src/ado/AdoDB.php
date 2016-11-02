<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdoDB
 *
 * @author daniel
 */
namespace src\ado;

class AdoDB
{
    protected $mysqli;
    protected $logs;

    /**
     * class constructor.
     * Make the Connection
     */
    public function __construct()
    {
        global $configuration, $logs;

        try {
            $this->mysqli = new \mysqli(
                $configuration->localhost,
                $configuration->user,
                $configuration->password,
                $configuration->database
            );
            
            $this->logs = $logs;
        } catch (Exception $exc) {
            $this->logs->logWrite($exc);
            http_response_code(500);
            exit();
        }
    }
    
    /**
     * Gets a state
     * @param integer $id id of table status
     * @return array state
     */
    public function prepareDb($query, $data)
    {
        $this->logs->logWrite($query, $data);
        return $this->mysqli->prepare($query);
    }
}
