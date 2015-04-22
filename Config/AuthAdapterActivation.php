<?php
/**
 * Auth Adapter Activation
 *
 * Activation class for Auth Adapter plugin.
 *
 * @package  AuthAdapter
 * @author   Mike Tallroth <mike.tallroth@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://github.com/miketallroth/croogo-authadapter
 */
class AuthAdapterActivation {

    public function beforeActivation(Controller $controller) {
        return true;
    }

    public function onActivation(Controller $controller) {
        // insert settings required to support your auth activities
    }

    public function beforeDeactivation(Controller $controller) {
        return true;
    }

    public function onDeactivation(Controller $controller) {
    }

}
