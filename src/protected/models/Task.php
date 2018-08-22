<?php

/**
 * Contains the Task class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.models._base.BaseTask');

/**
 * The Task class.
 *
 * Stores information about how the task will install, start and stop.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class Task extends BaseTask
{
    const QUERY_UNCONNECTED_TASK = "
        SELECT DISTINCT 
            task.task_hash_id
        FROM tbl_task AS task 
        LEFT JOIN tbl_node_has_task AS node_has_task 
            ON task.task_id = node_has_task.task_id
        WHERE
            node_has_task.node_id IS NULL
        LIMIT 1";

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

    /**
     *
     *
     * Object Methods
     *
     *
     */

    /**
     * Converts all of the task information to an array.
     *
     * Strictly contains information about the task.
     *
     * @return array All of the node information.
     */
    public function toArray()
    {
        return [
            'task_hash_id'    => $this->task_hash_id,
            'install_command' => $this->install_command,
            'start_command'   => $this->start_command,
            'end_command'     => $this->end_command,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at
        ];
    }

    /**
     *
     *
     * Scopes
     *
     *
     */

    /**
     * Filters criteria by task_hash_id.
     *
     * @param  string $task_hash_id The task hash id to filter by.
     * @return Task                 A reference to this.
     */
    public function taskHashID($task_hash_id)
    {
        $this->getDbCriteria()->compare('t.task_hash_id', $task_hash_id);
        return $this;
    }

    /**
     *
     *
     * Query Methods
     *
     *
     */
    
    /**
     * Returns with an unconnected task.
     *
     * Queries through the DB to find a task that is not yet connected
     * to a node and then returns it.
     * 
     * @return Task An unconnected Task or simply null.
     */
    public function getUnconnectedTask()
    {
        $connection = Yii::app()->db;
        $command = $connection->createCommand(self::QUERY_UNCONNECTED_TASK);
        $result = $command->query();

        
        if (sizeof($result) > 0) {
            foreach ($result as $task) {
                return self::model()->taskHashID($task['task_hash_id'])->find();
            }
        }

        return null;
    }
}