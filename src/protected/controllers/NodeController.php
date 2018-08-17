<?php

/**
 * Contains the NodeController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\ApiController;

/**
 * The NodeController Acts as a default controller.
 *
 * It sends the user to the given pages to get more information about how to utilize
 * the Node Api.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class NodeController extends ApiController
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
        if (empty($_POST)) {
            $this->renderJSONError("Not a proper http method type, please send a POST");
        } else if ($this->checkPostKey(self::SYSTEM_POST_KEY)) {
            $this->renderJSONError(
                $this->generatePostKeyMissingError(self::SYSTEM_POST_KEY)
            );
        } else if ($this->checkPostKey(self::CPU_POST_KEY)) {
            $this->renderJSONError(
                $this->generatePostKeyMissingError(self::CPU_POST_KEY)
            );
        } else if ($this->checkPostKey(self::HARD_DISK_POST_KEY)) {
            $this->renderJSONError(
                $this->generatePostKeyMissingError(self::HARD_DISK_POST_KEY)
            );
        } else {
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


    /**
     * Checks if the provided POST key name is missing.
     * 
     * @param  string $key_name The POST key name.
     * @return boolean          If the key is missing from POST.
     */
    private function checkPostKey($key_name = "")
    {
        return !array_key_exists($key_name, $_POST) || empty($_POST[$key_name]);
    }

    /**
     * Generates the Error message for when a POST key is missing.
     * 
     * @param  string $key_name The POST key name.
     * @return string           A error message.
     */
    private function generatePostKeyMissingError($key_name = "")
    {
        return "Error cannot be created as no " . $key_name .
                " was provided, please send a POST with '" . $key_name . "'";
    }
}
