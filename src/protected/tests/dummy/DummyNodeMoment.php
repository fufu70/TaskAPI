<?php

/**
 * Contains the DummyNodeMoment class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * DummyNodeMoment class. Helper in forging a dummy NodeMoment.
 *
 * Contains forge function to create a useless node moment.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class DummyNodeMoment
{
    /**
     * Creates a dummy node moment.
     * 
     * @param  int $node_id The actual ID of the node.
     * @return NodeMoment   A dummy node moment.
     */
    public static function forge($node_id)
    {
        $node_moment = new NodeMoment();
        $node_moment->node_moment_hash_id = Yii::app()->random->hashID();
        $node_moment->node_id = $node_id;
        $node_moment->cpu_usage = 'cpu_usage';
        $node_moment->memory_usage = 'memory_usage';
        $node_moment->hard_disk_usage = 'hard_disk_usage';
        $node_moment->temperature = 'temperature';
        $node_moment->weather = 'weather';
        $node_moment->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $node_moment->save();

        return $node_moment;
    }
}