<?php

/**
 * Contains the TaskController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * TaskController_Test class. A PHPUnit Test case class.
 *
 * Tests specific functions inside of the Task controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class TaskController_Test extends TestController
{

    /**
     * Sets the controller name
     */
    public function setUp()
    {
        $this->controller_name = 'TaskController';
    }

    /**
     *
     *
     *
     * Test
     *
     *
     *
     */

    /**
     * Tests the actionIndex method.
     */
    public function test_actionIndex()
    {
        $expectedOutput = "HTTP/1.1 200 OK\n" .
            "Content-type: application/json\n" .
            '{"installation":"https:\/\/github.com\/fufu70\/TaskAPI\/wiki\/Installation","testing":"https:\/\/github.com\/fufu70\/TaskAPI\/wiki\/Testing"}';

        $this->assertControllerResponse('actionIndex', '/task/', $expectedOutput);
    }
}