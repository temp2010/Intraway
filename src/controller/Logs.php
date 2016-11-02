<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace src\controller;

class Logs
{
    public function logWrite($message, $data = array())
    {
        $remote = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        $data   = print_r($data, true);
        $log    = "User:    ".$remote.' - '.date("F j, Y, g:i a").PHP_EOL.
                  "Message: ".$message.PHP_EOL.
                  "Data:    ".$data.PHP_EOL.
                  "-------------------------".PHP_EOL;
        if (file_exists("logs/")) {
            error_log($log, 3, "logs/".date("j.n.Y").".log");
        }
    }
}
