<?php

/**
 * Contains the Node class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.models._base.BaseNode');

/**
 * The Node class.
 *
 * Stores general node information.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class Node extends BaseNode
{
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
     * Converts all of the node information to an array.
     *
     * The node contains only information about its "self"
     *
     * @return array All of the node information.
     */
    public function toArray()
    {
        return [
            'node_hash_id' => $this->node_hash_id,
            'system'       => $this->system,
            'cpu'          => $this->cpu,
            'hard_disk'    => $this->hard_disk,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at
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
     * Filters criteria by node_hash_id.
     *
     * @param  string $node_hash_id The error hash id to filter by.
     * @return Node                 A reference to this.
     */
    public function nodeHashID($node_hash_id)
    {
        $this->getDbCriteria()->compare('t.node_hash_id', $node_hash_id);
        return $this;
    }
}