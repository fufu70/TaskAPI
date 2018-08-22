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
}
