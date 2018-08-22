<?php

/**
 * Contains the DummyNode class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * DummyNode class. Helper in forging a dummy Node.
 *
 * Contains forge function to create a useless node.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class DummyNode
{
    /**
     * Creates a dummy node.
     * 
     * @return Node A dummy node.
     */
    public static function forge()
    {
        $node = new Node();
        $node->node_hash_id = Yii::app()->random->hashID();
        $node->system = 'system';
        $node->cpu = 'cpu';
        $node->hard_disk = 'hard_disk';
        $node->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $node->updated_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $node->save();

        return $node;
    }
}