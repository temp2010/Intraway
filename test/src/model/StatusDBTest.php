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
require_once __DIR__ . '/../../../src/model/StatusDB.php';

class StatusDBTest extends PHPUnit_Framework_TestCase {

    /**
     * @var StatusDB
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new StatusDB;
    }

    /**
     * @covers StatusDB::getState
     * @todo   Implement testGetState().
     */
    public function testGetState() {
        $response = $this->object->getState(1);
        $this->assertTrue(is_array($response));
    }

    /**
     * @covers StatusDB::getStatus
     * @todo   Implement testGetStatus().
     */
    public function testGetStatus() {
        $response = $this->object->getStatus(1, 1, '%%');
        $this->assertTrue(is_array($response));
    }

    /**
     * @covers StatusDB::insert
     * @todo   Implement testInsert().
     */
    public function testInsert() {
        $response = $this->object->insert('Hi');
        $this->assertTrue($response);
    }

    /**
     * @covers StatusDB::delete
     * @todo   Implement testDelete().
     */
    public function testDelete() {
        $response = $this->object->delete(md5(1));
        $this->assertTrue($response);
    }

    /**
     * @covers StatusDB::checkID
     * @todo   Implement testCheckID().
     */
    public function testCheckID() {
        $response = $this->object->checkID(2);
        $this->assertTrue($response);
    }

    /**
     * @covers StatusDB::checkCODE
     * @todo   Implement testCheckCODE().
     */
    public function testCheckCODE() {
        $response = $this->object->checkCODE(md5(2));
        $this->assertTrue($response);
    }
}
