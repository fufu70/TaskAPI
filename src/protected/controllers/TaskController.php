<?php

/**
 * Contains the TaskController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\ApiController;

/**
 * The TaskController Acts as a default controller.
 *
 * It sends the user to the given pages to get more information about how to utilize
 * the Task Api.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class TaskController extends ApiController
{
    /**
     * A general response for the user to get information
     *
     * The response contains where to get general information about the TaskApi,
     * how to utilize the TaskApi, Configuration of the TaskApi, and Recommendations
     * for integrating the TaskApi into a server network.
     */
    public function actionIndex()
    {
        $this->renderJSON([
            'home' => 'https://github.com/fufu70/TaskAPI/wiki',
        ]);
    }
}
