<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once __DIR__ . '/../../../src/controller/StatusAPI.php';

class StatusAPITest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StatusAPI
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \src\controller\StatusAPI;
    }

    /**
     * @covers StatusAPI::response
     * @todo   Implement testResponse().
     */
    public function testResponse()
    {
        $this->assertTrue($this->object->response(200, null, "a"));
    }
}
