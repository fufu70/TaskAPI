<?php

/**
 * Contains the NodeController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\Reflection;

/**
 * NodeController_Test class. A PHPUnit Test case class.
 *
 * Tests specific functions inside of the Node controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class NodeController_Test extends TestController
{

    /**
     * Sets the controller name
     */
    public function setUp()
    {
        $this->controller_name = 'NodeController';
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
     * Contains an array of system, cpu and hard_disk information for creating nodes.
     * 
     * @return array An array of POST data
     */
    public function input_actionNodeCreate()
    {
        return [
            [
                [
                    'system' => 'System:    Host: taskapi Kernel: 4.4.0-47-generic x86_64 (64 bit) Console: tty 0 Distro: Ubuntu 16.04 xenial',
                    'cpu' => 'CPU:       Dual core Intel Core i7-5557U (-MCP-) cache: 4096 KB',
                    'hard_disk' => 'Partition: ID-1: / size: 9.7G used: 1.9G (20%) fs: ext4 dev: /dev/sda1'
                ]
            ],
        ];
    }

    /**
     * Contains an array of missing system, cpu and hard_disk information for creating nodes
     * and their respective fail cases.
     * 
     * @return array An array of POST data with expected fail responses.
     */
    public function input_actionNodeCreateFail()
    {
        return [
            [
                [
                    
                ],
                'Not a proper http method type, please send a POST'
            ],
            [
                [
                    'system' => ''
                ],
                "Error cannot be created as no system was provided, please send a POST with 'system'"
            ],
            [
                [
                    'system' => 'System Value',
                    'cpu' => ''
                ],
                "Error cannot be created as no cpu was provided, please send a POST with 'cpu'"
            ],
            [
                [
                    'system' => 'System Value',
                    'cpu' => 'CPU Value',
                    'hard_disk' => ''
                ],
                "Error cannot be created as no hard_disk was provided, please send a POST with 'hard_disk'"
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
     * Tests the actionCreate method.
     * 
     * @dataProvider input_actionNodeCreate
     * 
     * @param  array $post
     */
    public function test_actionNodeCreate($post)
    {
        $_POST = $post;
        
        $node_json = $this->getOKJSON('/node/create', 'actionCreate');

        $this->assertTrue(Node::model()->nodeHashID($node_json->node_hash_id)->exists());
        
        if (Node::model()->nodeHashID($node_json->node_hash_id)->exists()) {
            $this->assertCreationEquals(Node::model()->nodeHashID($node_json->node_hash_id)->find());
        }
    }

    /**
     * Tests the actionCreate method for failing messages.
     * 
     * @dataProvider input_actionNodeCreateFail
     * 
     * @param  array  $post
     * @param  string $fail_response
     */
    public function test_actionNodeCreateFail($post, $fail_response)
    {
        $_POST = $post;
        
        $fail_json = $this->getFailJSON('/node/create', 'actionCreate');

        $this->assertTrue($fail_json->errors->general[0] == $fail_response);
    }

    /**
     * Confirms that the node created is the same as that of the POST passed.
     * 
     * @param  Node  $node The node created.
     */
    private function assertCreationEquals(Node $node) {
        $this->assertTrue($node->system == $_POST['system']);
        $this->assertTrue($node->cpu == $_POST['cpu']);
        $this->assertTrue($node->hard_disk == $_POST['hard_disk']);
    }
}