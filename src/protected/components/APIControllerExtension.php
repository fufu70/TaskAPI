<?php

/**
 * Contains the ApiControllerExtension class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\ApiController;

/**
 * The ApiControllerExtension Acts as a default controller for all APIControllers.
 *
 * It houses generalized functions for error validation for the API controller.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class ApiControllerExtension extends ApiController
{
    /**
     * Validates the POST request against a list of necessary keys and 
     * 
     * @param  array  $key_validation Array containing keys to validate against.
     * @return boolean                If the request is valid or not.
     */
    protected function validateRequest(array $key_validation = [])
    {
        if (empty($_POST)) {
            $this->renderJSONError("Not a proper http method type, please send a POST");
            return false;
        }

        foreach ($key_validation as $key => $value)
        {
            if ($this->checkPostKey($value)) {
                $this->renderJSONError(
                    $this->generatePostKeyMissingError($value)
                );
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if the provided POST key name is missing.
     * 
     * @param  string $key_name The POST key name.
     * @return boolean          If the key is missing from POST.
     */
    protected function checkPostKey($key_name = "")
    {
        return !array_key_exists($key_name, $_POST) || empty($_POST[$key_name]);
    }

    /**
     * Generates the Error message for when a POST key is missing.
     * 
     * @param  string $key_name The POST key name.
     * @return string           A error message.
     */
    protected function generatePostKeyMissingError($key_name = "")
    {
        return "Error cannot be created as no " . $key_name .
                " was provided, please send a POST with '" . $key_name . "'";
    }
}