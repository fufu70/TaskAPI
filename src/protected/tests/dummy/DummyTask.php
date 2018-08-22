<?php

/**
 * Contains the DummyTask class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * DummyTask class. Helper in forging a dummy Task.
 *
 * Contains forge function to create a useless task.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class DummyTask
{
    /**
     * Creates a dummy task.
     * 
     * @return Task A dummy task.
     */
    public static function forge()
    {
        $task = new Task();
        $task->task_hash_id = Yii::app()->random->hashID();
        $task->install_command = 'install_command';
        $task->start_command = 'start_command';
        $task->end_command = 'end_command';
        $task->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $task->updated_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $task->save();

        return $task;
    }
}