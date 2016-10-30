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
require_once __DIR__ . '/../model/StatusDB.php';

class StatusAPI {
    const PAGENUMBER  = 1;
    const ROWSPERPAGE = 20;
    
    /**
     * Start the rest methods
     */
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
            case 'DELETE':
                $this->deleteStatus();
                break;
            default :
                $this->response(405);
                break;
        }
    }
    
    /**
     * the return of the response ago
     */
    public function response($status=200, $code = "", $message = "", $link = "http://some.url/docs") {
        http_response_code($status);
        if (!empty($message)) {
            $response = array("code" => $code, "message" => $message, "link" => $link);
            echo json_encode($response, JSON_PRETTY_PRINT);
            return true;
        }
    }
    
    /**
     * this endpoint is used to retreive status messages, it will get
     * status messages paginated. By default, it will retrrieve 20 items, sorted
     * by date, newers first.
     */
    public function getStatus() {
        $p      = filter_input(INPUT_GET, 'p');
        $r      = filter_input(INPUT_GET, 'r');
        $q      = filter_input(INPUT_GET, 'q');
        $id     = filter_input(INPUT_GET, 'id');
        $code   = filter_input(INPUT_GET, 'code');
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
                    return true;
                } else {
                    $this->response(404, 400000, "status messge not found");
                }
            } else {                
                if (!is_numeric($p)) {
                    $this->response(400, 400002, "invalid number of page");
                } elseif (!is_numeric($r)) {
                    $this->response(400, 400001, "invalid number of rows");
                } else {
                    $response = $db->getStatus(($p - 1) * $r, $r, '%'.$q.'%');
                    echo json_encode($response, JSON_PRETTY_PRINT);
                    return true;
                }
            }
        } elseif ($action == 'confirmation' && $code) {
            $db = new StatusDB();
            $response = $db->checkCODE($code);
            if ($response) {
                $response = $db->delete($code);
                if ($response) {
                    $this->response(200);
                }
            } else {
                $this->response(404, 400000, "status messge not found");
            }
        }  else {
            $this->response(400);
        }
    }
    
    /**
     * this endpoint its used to publish a new status message,
     * the messages can be either, owned by someone, or be an annon. status messages
     * annon statuses are send with "annonymus" as value in email.
     * if an email address is received, an e-mail will be sent with a code to validate ownership of the message.
     * the message will be published after a succesfull validation
     */
    function saveStatus() {
        $action = filter_input(INPUT_GET, 'action');
        
        if ($action == 'status') {
            $obj    = json_decode(file_get_contents('php://input'));
            $objArr = (array) $obj;
            $status = new StatusDB();
            if (empty($objArr)) {
                $this->response(201, "Nothing to add. Check json");
            } else if (isset($obj->status) && strlen($obj->status) <= 120) {
                if (isset($obj->email)) {
                    $email = $this->test_input($obj->email);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $this->response(201, 400003, "missing email addres");
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
    
    /**
     * Deletes the status message, it will also send an email
     * with a link que te confirm the operation
     */
    function deleteStatus() {
        $id     = filter_input(INPUT_GET, 'id');
        $action = filter_input(INPUT_GET, 'action');
        if ($action && $id) {
            if ($action == 'status') {
                $db = new StatusDB();
                if ($db->checkID($id)) {
                    if($db->checkID($id, TRUE)) {
                        $response = $db->getState($id);
                        echo $response[0]['email'].", ".md5($response[0]['id']);
                        $send = mail($response[0]['email'], md5($response[0]['id']), md5($response[0]['id']));
                        if ($send) {
                            echo json_encode($response, JSON_PRETTY_PRINT);
                        } else {
                            $this->response(400);
                        }
                    } else {
                        $this->response(400, 400005, "annon statuses cannot be deleted");
                    }
                } else {
                    $this->response(404, 400000, "status messge not found");
                }
            } else {
                $this->response(400);
            }
        }
        $this->response(404);
    }
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }
}