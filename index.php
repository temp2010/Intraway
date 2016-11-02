<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require "autoload.php";

use config\Config as config;
use src\controller as controller;

$configuration = new Config();
$logs          = new controller\Logs();
$statusAPI     = new controller\StatusAPI();

$statusAPI->API();
