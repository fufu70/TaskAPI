<?php

/**
 * Contains the NodeMoment class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.models._base.BaseNodeMoment');

/**
 * The NodeMoment class.
 *
 * Stores momentary informationa about the node.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class NodeMoment extends BaseNodeMoment
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
     * Converts all of the node moment information to an array.
     *
     * The node moment contains information about the current moment
     * of the node but also the node itself.
     *
     * @return array All of the node information.
     */
    public function toArray()
    {
        return [
            'node_moment_hash_id' => $this->node_moment_hash_id,
            'node_hash_id'        => $this->node->node_hash_id,
            'cpu_usage'           => $this->cpu_usage,
            'memory_usage'        => $this->memory_usage,
            'hard_disk_usage'     => $this->hard_disk_usage,
            'temperature'         => $this->temperature,
            'weather'             => $this->weather,
            'created_at'          => $this->created_at
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
     * Filters criteria by node_moment_hash_id.
     *
     * @param  string $node_moment_hash_id The node moment hash id to filter by.
     * @return NodeMoment                  A reference to this.
     */
    public function nodeMomentHashID($node_moment_hash_id)
    {
        $this->getDbCriteria()->compare('t.node_moment_hash_id', $node_moment_hash_id);
        return $this;
    }

    /**
     * Filters criteria by node_id.
     *
     * @param  string $node_id The node id to filter by.
     * @return NodeMoment      A reference to this.
     */
    public function nodeID($node_id)
    {
        $this->getDbCriteria()->compare('t.node_id', $node_id);
        return $this;
    }
}