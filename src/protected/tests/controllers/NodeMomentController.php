<?php

/**
 * Contains the NodeMomentController_Test class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\Reflection;

/**
 * NodeMomentController_Test class. A PHPUnit Test case class.
 *
 * Tests specific functions inside of the NodeMoment controller class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class NodeMomentController_Test extends TestController
{

    /**
     * Sets the controller name
     */
    public function setUp()
    {
        $this->controller_name = 'NodeMomentController';
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
     * Contains an array of system, cpu and hard_disk information for creating node_moments.
     * 
     * @return array An array of POST data
     */
    public function input_actionNodeMomentCreate()
    {
        return [
            [
                [
                    'cpu_usage' => "Processes: CPU: % used - top 5 active
           1: cpu: 5.0% command: -bash pid: 31028
           2: cpu: 0.2% command: systemd pid: 1
           3: cpu: 0.0% command: sshd: pid: 31027
           4: cpu: 0.0% daemon: ~kworker/1:3~ pid: 30970
           5: cpu: 0.0% daemon: ~sd-pam~ pid: 30968",
                    'memory_usage' => "Processes: Memory: MB / % used - Used/Total: 277.2/992.3MB - top 5 active
           1: mem: 108.62MB (10.9%) command: mysqld pid: 7816
           2: mem: 25.50MB (2.5%) command: apache2 pid: 16994
           3: mem: 15.55MB (1.5%) command: apache2 pid: 17000
           4: mem: 14.93MB (1.5%) command: apache2 pid: 16998
           5: mem: 9.05MB (0.9%) command: apache2 pid: 16997",
                    'hard_disk_usage' => "Partition: ID-1: / size: 9.7G used: 1.9G (20%) fs: ext4 dev: /dev/sda1
           ID-2: /vagrant size: 932G used: 586G (63%) fs: vboxsf dev: N/A
           ID-3: /home/vagrant/sql size: 932G used: 586G (63%) fs: vboxsf dev: N/A
           ID-4: /home/vagrant/install size: 932G used: 586G (63%) fs: vboxsf dev: N/A
           ID-5: /var/www/task_api/src size: 932G used: 586G (63%) fs: vboxsf dev: N/A
           ID-6: /var/www/task_api/build size: 932G used: 586G (63%) fs: vboxsf dev: N/A",
                    'temperature' => "Sensors:   None detected - is lm-sensors installed and configured?",
                    'weather' => "Weather:   Conditions: 88 F (31 C) - Mostly Cloudy Time: August 17, 6:11 PM EDT",
                ]
            ],
        ];
    }

    /**
     * Contains an array of missing system, cpu and hard_disk information for creating node_moments
     * and their respective fail cases.
     * 
     * @return array An array of POST data with expected fail responses.
     */
    public function input_actionNodeMomentCreateFail()
    {
        return [
            [
                [
                    
                ],
                'Not a proper http method type, please send a POST'
            ],
            [
                [
                    'node_hash_id' => ''
                ],
                "Error cannot be created as no node_hash_id was provided, please send a POST with 'node_hash_id'"
            ],
            [
                [
                    'node_hash_id' => 'node_hash_id value',
                    'cpu_usage' => '',
                ],
                "Error cannot be created as no cpu_usage was provided, please send a POST with 'cpu_usage'"
            ],
            [
                [
                    'node_hash_id' => 'node_hash_id value',
                    'cpu_usage' => 'cpu_usage value',
                    'memory_usage' => '',
                ],
                "Error cannot be created as no memory_usage was provided, please send a POST with 'memory_usage'"
            ],
            [
                [
                    'node_hash_id' => 'node_hash_id value',
                    'cpu_usage' => 'cpu_usage value',
                    'memory_usage' => 'memory_usage value',
                    'hard_disk_usage' => '',
                ],
                "Error cannot be created as no hard_disk_usage was provided, please send a POST with 'hard_disk_usage'"
            ],
            [
                [
                    'node_hash_id' => 'node_hash_id value',
                    'cpu_usage' => 'cpu_usage value',
                    'memory_usage' => 'memory_usage value',
                    'hard_disk_usage' => 'hard_disk_usage value',
                    'temperature' => '',
                ],
                "Error cannot be created as no temperature was provided, please send a POST with 'temperature'"
            ],
            [
                [
                    'node_hash_id' => 'node_hash_id value',
                    'cpu_usage' => 'cpu_usage value',
                    'memory_usage' => 'memory_usage value',
                    'hard_disk_usage' => 'hard_disk_usage value',
                    'temperature' => 'temperature value',
                    'weather' => '',
                ],
                "Error cannot be created as no weather was provided, please send a POST with 'weather'"
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
     * @dataProvider input_actionNodeMomentCreate
     * 
     * @param  array $post
     */
    public function test_actionNodeMomentCreate($post)
    {
        // create node
        $node = DummyNode::forge();
        $post['node_hash_id'] = $node->node_hash_id;
        $_POST = $post;
        
        $node_moment_json = $this->getOKJSON('/nodemoment/create', 'actionCreate');

        $this->assertTrue(NodeMoment::model()->nodeMomentHashID($node_moment_json->node_moment_hash_id)->exists());
        
        if (NodeMoment::model()->nodeMomentHashID($node_moment_json->node_moment_hash_id)->exists()) {
            $this->assertCreationEquals(NodeMoment::model()->nodeMomentHashID($node_moment_json->node_moment_hash_id)->find());
        }
    }

    /**
     * Tests the actionCreate method for failing messages.
     * 
     * @dataProvider input_actionNodeMomentCreateFail
     * 
     * @param  array  $post
     * @param  string $fail_response
     */
    public function test_actionNodeMomentCreateFail($post, $fail_response)
    {
        $_POST = $post;
        
        $fail_json = $this->getFailJSON('/nodemoment/create', 'actionCreate');

        $this->assertTrue($fail_json->errors->general[0] == $fail_response);
    }

    /**
     * Confirms that the node_moment created is the same as that of the POST passed.
     * 
     * @param  NodeMoment  $node_moment The node_moment created.
     */
    private function assertCreationEquals(NodeMoment $node_moment) {
        $this->assertTrue($node_moment->node->node_hash_id == $_POST['node_hash_id']);
        $this->assertTrue($node_moment->cpu_usage == $_POST['cpu_usage']);
        $this->assertTrue($node_moment->memory_usage == $_POST['memory_usage']);
        $this->assertTrue($node_moment->hard_disk_usage == $_POST['hard_disk_usage']);
        $this->assertTrue($node_moment->temperature == $_POST['temperature']);
        $this->assertTrue($node_moment->weather == $_POST['weather']);
    }
}