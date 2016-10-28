<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PeopleAPI
 *
 * @author daniel
 */
require_once('src/model/StatusDB.php');

class StatusAPI {
    const PAGENUMBER  = 1;
    const ROWSPERPAGE = 20;
    
    public function API() {
        header('Content-Type: application/JSON');
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                $this->getStatus();
                break;
            case 'POST':
                $this->saveStatus();
                break;
            case 'PUT':
                $this->updatePeople();
                break;
            case 'DELETE':
                $this->deletePeople();
                break;
            default :
                $this->response(405);
                break;
        }
    }
    
    public function response($code=200, $message="", $link="http://some.url/docs") {
        http_response_code($code);
        if (!empty($message)) {
            $response = array("code" => $code, "message" => $message, "link" => $link);
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    }
    
    public function getStatus() {
        $p      = filter_input(INPUT_GET, 'p');
        $r      = filter_input(INPUT_GET, 'r');
        $q      = filter_input(INPUT_GET, 'q');
        $id     = filter_input(INPUT_GET, 'id');
        $action = filter_input(INPUT_GET, 'action');
        
        if (!$p) {
            $p = self::PAGENUMBER;
        }
        if (!$r) {
            $r = self::ROWSPERPAGE;
        }
        
        if ($action == 'status') {
            $db = new StatusDB();
            if ($id) {
                $response = $db->getState($id);
                if ($response) {
                    echo json_encode($response, JSON_PRETTY_PRINT);
                } else {
                    $this->response(404, "status messge not found");
                }
            } else {                
                if (!is_numeric($p)) {
                    $this->response(400, "invalid number of page");
                } elseif (!is_numeric($r)) {
                    $this->response(400, "invalid number of rows");
                } else {
                    $response = $db->getStatus(($p - 1) * $r, $r, '%'.$q.'%');
                    echo json_encode($response, JSON_PRETTY_PRINT);
                }
            }
        } else {
            $this->response(400);
        }
    }
    
    function saveStatus() {
        $action = filter_input(INPUT_GET, 'action');
        
        if ($action == 'status') {
            $obj    = json_decode(file_get_contents('php://input'));
            $objArr = (array) $obj;
            $status = new StatusDB();
            if (empty($objArr)) {
                $this->response(201, "Nothing to add. Check json");
            } else if (isset($obj->status)) {
                if (isset($obj->email)) {
                    $email = $this->test_input($obj->email);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $this->response(201, "missing email addres");
                    } else {
                        $status->insert($obj->status, $email);
                        $this->response(200, "success", "new record added");
                    }
                } else {
                    $status->insert($obj->status);
                    $this->response(200, "success", "new record added");
                }
            } else {
                $this->response(201, "The property is not defined");
            }
        } else {
            $this->response(400);
        }
    }
    
    function updatePeople() {
        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action']=='peoples') {
                $obj = json_decode( file_get_contents('php://input') );
                $objArr = (array)$obj;
                if (empty($objArr)) {
                    $this->response(422,"error","Nothing to add. Check json");
                } elseif (isset($obj->name)) {
                    $db = new PeopleDB();
                    $db->update($_GET['id'], $obj->name);
                    $this->response(200,"success","Record updated");                  
                } else {
                    $this->response(422,"error","The property is not defined");
                }
                exit;
           }
        }
        $this->response(400);
    }
    
    function deletePeople() {
        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action']=='peoples') { 
                $db = new PeopleDB();
                $db->delete($_GET['id']);
                $this->response(204);
                exit;
            }
        }
        $this->response(400);
    }
    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }
}