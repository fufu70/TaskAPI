<?php

/**
 * Contains the TaskController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * The TaskController Acts as a default controller.
 *
 * It sends the user to the given pages to get more information about how to utilize
 * the Task Api, and allows the user to create tasks.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class TaskController extends ApiControllerExtension
{
    const INSTALL_COMMAND_POST_KEY = 'install_command';
    const START_COMMAND_POST_KEY = 'start_command';
    const END_COMMAND_POST_KEY = 'end_command';
    const NODE_HASH_ID_COMMAND_POST_KEY = 'node_hash_id';

    /**
     * A general response for the user to get information
     *
     * The response contains where to get general information about the TaskApi,
     * how to utilize the TaskApi, Configuration of the TaskApi, and Recommendations
     * for integrating the TaskApi into a server network.
     */
    public function actionIndex()
    {
        $this->renderJSON([
            'api' => [
                'node' => 'https://github.com/fufu70/TaskAPI/wiki/Node-API',
                'task' => 'https://github.com/fufu70/TaskAPI/wiki/Task-API'
            ],
            'installation' => 'https://github.com/fufu70/TaskAPI/wiki/Installation',
            'testing' => 'https://github.com/fufu70/TaskAPI/wiki/Testing',
        ]);
    }

    /**
     * Creates a Task from the provided information.
     *
     * @return JSON The task array or an error response.
     */
    public function actionCreate()
    {
        if ($this->validateRequest([
            self::INSTALL_COMMAND_POST_KEY, 
            self::START_COMMAND_POST_KEY, 
            self::END_COMMAND_POST_KEY]))
        {
            try {
                $task = $this->createTask();

                if (sizeof($task->getErrors()) == 0) {
                    $this->renderJSON($task->toArray());
                } else {
                    $this->renderJSONError($task->getErrors());
                }
            } catch (Exception $e) {
                $this->renderJSONError($e->getMessage(), 500);
            }
        }
    }

    /**
     * Requests a Task from the provided information.
     *
     * @return JSON The task array or an error response.
     */
    public function actionRequest()
    {
        if ($this->validateRequest([self::NODE_HASH_ID_COMMAND_POST_KEY])
            && $this->validateNodeExists())
        {
            try {
                $task = $this->requestTask();

                if (is_null($task)) {
                    $this->renderJSONError("Error, no tasks are available. Please try again later.");
                } else if (sizeof($task->getErrors()) == 0) {
                    $this->renderJSON($task->toArray());
                } else {
                    $this->renderJSONError($task->getErrors());
                }
            } catch (Exception $e) {
                $this->renderJSONError($e->getMessage(), 500);
            }
        }
    }

    /**
     * Creates the task from the current POST.
     * 
     * @return Task The new Task
     */
    private function createTask()
    {
        $task = new Task();
        $task->task_hash_id = Yii::app()->random->hashID();
        $task->install_command = $_POST['install_command'];
        $task->start_command = $_POST['start_command'];
        $task->end_command = $_POST['end_command'];
        $task->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $task->updated_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $task->save();

        return $task;
    }

    /**
     * Requests a task from the current POST.
     *
     * If a Task exists that has not been associated with a node then
     * associate the current node with the newly found task and return
     * that task. 
     * 
     * @return Task The new Task
     */
    private function requestTask()
    {
        // find task
        $task = Task::model()->getUnconnectedTask();

        if (!is_null($task))
        {
            $node_has_task = new NodeHasTask();
            $node_has_task->task_id = $task->task_id;
            $node_has_task->node_id = Node::model()->nodeHashId($_POST[self::NODE_HASH_ID_COMMAND_POST_KEY])->find()->node_id;
            $node_has_task->save();
        }

        return $task;
    }

    /**
     * Validates if the node exists in the current context.
     *
     * Validates the existence of the node if the current node_hash_id is in the DB.
     * If this fails then output a json error response.
     * 
     * @return boolean If the node exists.
     */
    private function validateNodeExists()
    {
        if (!Node::model()->nodeHashId($_POST[self::NODE_HASH_ID_COMMAND_POST_KEY])->exists())
        {
            $this->renderJSONError("Error cannot be created as no existing node_hash_id was provided, please send a POST with an existing 'node_hash_id'");
            return false;
        }
        return true;
    }
}
