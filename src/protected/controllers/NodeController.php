<?php

/**
 * Contains the NodeController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * The NodeController Acts as a default controller.
 *
 * It sends the user to the given pages to get more information about how to utilize
 * the Node Api.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class NodeController extends ApiControllerExtension
{
    const SYSTEM_POST_KEY = 'system';
    const CPU_POST_KEY = 'cpu';
    const HARD_DISK_POST_KEY = 'hard_disk';

    /**
     * Lists all of the nodes currently on the system.
     * 
     * @return JSON All of the nodes contained in an array.
     */
    public function actionList()
    {
        try {
            $nodes = Node::model()->findAll();
            $node_arr = [];

            foreach ($nodes as $node) {
                $node_arr[] = $node->toArray();
            }

            $this->renderJSON($node_arr);
        } catch (Exception $e) {
            $this->renderJSONError($e->getMessage(), 500);
        }
    }

    /**
     * Lists all of the node moments associated with the node.
     * 
     * @return JSON All of the node moments contained in an array.
     */
    public function actionMoments()
    {
        $hash_id = $this->getHashID('node/moments');
        try {
            if (Node::model()->nodeHashID($hash_id)->exists())
            {
                $node = Node::model()->nodeHashID($hash_id)->find();
                $node_moments = NodeMoment::model()->nodeID($node->node_id)->findAll();
                $node_moment_arr = [];
                
                foreach ($node_moments as $node_moment) {
                    $node_moment_arr[] = $node_moment->toArray();
                }

                $this->renderJSON($node_moment_arr);   
            }
            else
            {
                $this->renderJSONError("Error moments cannot be retrieved as node does not exist. Please provide a correct 'node_hash_id'");
            }
        } catch (Exception $e) {
            $this->renderJSONError($e->getMessage(), 500);
        }
    }

    /**
     * Creates a Node from the provided information.
     *
     * @return JSON The node array or an error response.
     */
    public function actionCreate()
    {
        if ($this->validateRequest([
            self::SYSTEM_POST_KEY,
            self::CPU_POST_KEY,
            self::HARD_DISK_POST_KEY])) 
        {
            try {
                $node = $this->createNode();

                if (sizeof($node->getErrors()) == 0) {
                    $this->renderJSON($node->toArray());
                } else {
                    $this->renderJSONError($node->getErrors());
                }
            } catch (Exception $e) {
                $this->renderJSONError($e->getMessage(), 500);
            }
        }
    }

    /**
     * Creates the node from the current POST.
     * 
     * @return Node The new Node
     */
    private function createNode()
    {
        $node = new Node();
        $node->node_hash_id = Yii::app()->random->hashID();
        $node->system = $_POST['system'];
        $node->cpu = $_POST['cpu'];
        $node->hard_disk = $_POST['hard_disk'];
        $node->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $node->updated_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $node->save();

        return $node;
    }
}
