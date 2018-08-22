<?php

/**
 * Contains the NodeMomentController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * The NodeMomentController Acts as a default controller.
 *
 * It sends the user to the given pages to get more information about how to utilize
 * the NodeMoment Api.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class NodeMomentController extends ApiControllerExtension
{
    const NODE_HASH_ID_POST_KEY = 'node_hash_id';
    const CPU_USAGE_POST_KEY = 'cpu_usage';
    const MEMORY_USAGE_POST_KEY = 'memory_usage';
    const HARD_DISK_USAGE_POST_KEY = 'hard_disk_usage';
    const TEMPERATURE_POST_KEY = 'temperature';
    const WEATHER_POST_KEY = 'weather';

    /**
     * Creates a NodeMoment from the provided information.
     *
     * @return JSON The node array or an error response.
     */
    public function actionCreate()
    {
        if ($this->validateRequest([
                self::NODE_HASH_ID_POST_KEY, 
                self::CPU_USAGE_POST_KEY, 
                self::MEMORY_USAGE_POST_KEY, 
                self::HARD_DISK_USAGE_POST_KEY, 
                self::TEMPERATURE_POST_KEY, 
                self::WEATHER_POST_KEY])) 
        {
            try {

                $node_moment = $this->createNodeMoment();

                if (sizeof($node_moment->getErrors()) == 0) {
                    $this->renderJSON($node_moment->toArray());
                } else {
                    $this->renderJSONError($node_moment->getErrors());
                }
            } catch (Exception $e) {
                $this->renderJSONError($e->getMessage(), 500);
            }
        }
    }

    /**
     * Creates the node from the current POST.
     * 
     * @return NodeMoment The new NodeMoment
     */
    private function createNodeMoment()
    {
        $node_moment = new NodeMoment();
        $node_moment->node_moment_hash_id = Yii::app()->random->hashID();
        $node_moment->node_id = Node::model()->nodeHashID($_POST[self::NODE_HASH_ID_POST_KEY])->find()->node_id;
        $node_moment->cpu_usage = $_POST[self::CPU_USAGE_POST_KEY];
        $node_moment->memory_usage = $_POST[self::MEMORY_USAGE_POST_KEY];
        $node_moment->hard_disk_usage = $_POST[self::HARD_DISK_USAGE_POST_KEY];
        $node_moment->temperature = $_POST[self::TEMPERATURE_POST_KEY];
        $node_moment->weather = $_POST[self::WEATHER_POST_KEY];
        $node_moment->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $node_moment->save();

        return $node_moment;
    }
}
