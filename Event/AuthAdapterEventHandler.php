<?php

App::uses('CakeEventListener', 'Event');

/**
 * AuthAdapter Event Handler
 *
 * @category Event
 * @package  AuthAdapter
 * @license  
 * @link     
 *
 * An event handler to hook the AuthAdapter Authentication Adapter into the
 * standard Cake Auth component.
 */
class AuthAdapterEventHandler implements CakeEventListener {

/**
 * implementedEvents
 *
 * @return array
 */
	public function implementedEvents() {
		return array(
			'Controller.Users.beforeAdminLogin' => array(
				'callable' => 'beforeLogin',
			),
			'Controller.Users.beforeLogin' => array(
				'callable' => 'beforeLogin',
			),
		);
	}

	/**
     * Includes the AuthAdapterAuthenticate adapter into the authentication
     * stream of the Auth component.
	 */
	public function beforeLogin($event) {

        // get the Auth component from the controller (subject of the event)
        $Auth = $event->subject->Auth;

        // Include the AuthAdapter in the authentication stream, and
        // re-construct the objects to include this new one.
        // This refers to Controller/Component/Auth/AuthAdapterAuthenticate.php
        //
        // The code here simply adds our adapter to the end of the list
        // which is processed sequentially. Instead, if we wanted to be
        // processed first or any other appropriate location, include
        // the required logic here.
        //
        // Additionally, if you had multiple custom adapters, you could choose
        // to simply add them to the end of the list here, then when enabling
        // various authentication plugins in the admin dashboard, you can
        // change the order of the plugins (up/down arrows) to affect what
        // order they will be called here and during the Auth stream. Doing
        // this doesn't allow you to manipulate them in the dashboard AND
        // insert them before the built-in adapters, but with some ingenuity
        // most anything could be accomplished.
        //
        $Auth->authenticate[] = 'AuthAdapter.AuthAdapter';
        $Auth->constructAuthenticate();

        // Similar actions could be taken to include an AuthAdapterAuthorize
        // adapter into the authorization stream of the Auth component.
        // This refers to Controller/Component/Auth/AuthAdapterAuthorize.php
        // $Auth->authorize[] = 'AuthAdapter.AuthAdapter';
        // $Auth->constructAuthorize();

        return;

	}

}
