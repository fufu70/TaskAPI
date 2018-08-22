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
     * Input
     *
     *
     *
     */

    /**
     * Contains an array of install_command, start_command and end_command information
     * for creating tasks.
     * 
     * @return array An array of POST data
     */
    public function input_actionTaskCreate()
    {
        return [
            [
                [
                    'install_command' => '$(git clone https://github.com/fufu70/dissemination-of-culture-js; sudo apt-get install node)',
                    'start_command'   => '$(node index.js 5 1000 3 6 > result.txt)',
                    'end_command'     => '$(curl -i -X POST -H "Content-Type: multipart/form-data" -F "file=@result.txt" 192.168.201.71/create)'
                ]
            ],
        ];
    }

    /**
     * Contains an array of missing install_command, start_command and end_command 
     * information for creating tasks and their respective fail cases.
     * 
     * @return array An array of POST data with expected fail responses.
     */
    public function input_actionTaskCreateFail()
    {
        return [
            [
                [
                    
                ],
                'Not a proper http method type, please send a POST'
            ],
            [
                [
                    'install_command' => ''
                ],
                "Error cannot be created as no install_command was provided, please send a POST with 'install_command'"
            ],
            [
                [
                    'install_command' => 'Install Value',
                    'start_command'   => ''
                ],
                "Error cannot be created as no start_command was provided, please send a POST with 'start_command'"
            ],
            [
                [
                    'install_command' => 'Install Value',
                    'start_command'   => 'Start Value',
                    'end_command'     => ''
                ],
                "Error cannot be created as no end_command was provided, please send a POST with 'end_command'"
            ],
        ];
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

    /**
     * Tests the actionCreate method.
     * 
     * @dataProvider input_actionTaskCreate
     * 
     * @param  array $post
     */
    public function test_actionTaskCreate($post)
    {
        $_POST = $post;
        
        $task_json = $this->getOKJSON('/task/create', 'actionCreate');

        $this->assertTrue(Task::model()->taskHashID($task_json->task_hash_id)->exists());
        
        if (Task::model()->taskHashID($task_json->task_hash_id)->exists()) {
            $this->assertCreationEquals(Task::model()->taskHashID($task_json->task_hash_id)->find());
        }
    }

    /**
     * Tests the actionCreate method for failing messages.
     * 
     * @dataProvider input_actionTaskCreateFail
     * 
     * @param  array  $post
     * @param  string $fail_response
     */
    public function test_actionTaskCreateFail($post, $fail_response)
    {
        $_POST = $post;
        
        $fail_json = $this->getFailJSON('/task/create', 'actionCreate');

        $this->assertTrue($fail_json->errors->general[0] == $fail_response);
    }

    /**
     * Confirms that the task created is the same as that of the POST passed.
     * 
     * @param  Task  $task The task created.
     */
    private function assertCreationEquals(Task $task) {
        $this->assertTrue($task->install_command == $_POST['install_command']);
        $this->assertTrue($task->start_command == $_POST['start_command']);
        $this->assertTrue($task->end_command == $_POST['end_command']);
    }
}