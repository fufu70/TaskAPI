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
