<?php

App::uses('FormAuthenticate', 'Controller/Component/Auth');

/*
 * Extends the CakePHP FormAuthenticate Adapter class and overrides
 * the _findUser function.
 *
 * Most, if not all, the code in this adapter is completely bogus. The
 * purpose of this Plugin is to demonstrate how to hook in your own
 * adapter into the authentication process, not to provide a real
 * implementation.
 */
class AuthAdapterAuthenticate extends FormAuthenticate {

    /**
     * Accepts a username and password, calls your custom authentication
     * function, then returns the local (croogo) user record corresponding
     * to the username, false on failure.
     *
     * This function should handle the overall mechanism, whereas the
     * custom auth function should handle the specifics of interfacing
     * with the authentication database such as LDAP, NIS, or whatever.
     *
     * Many different approaches could be taken here and should be
     * considered individually, so I am not including much with regard to
     * this. For example, if a user authenticates via your authentication
     * routine, maybe you want them to be able to bypass the 'register'
     * process, but that also means you will need to create a local record
     * for them in the croogo database with appropriate roles, permissions,
     * etc.
     *
     * @param string $username The username/identifier.
     * @param string $password The unhashed password.
     * @return Mixed Either false on failure, or an array of user data.
     */
    protected function _findUser($username, $password = null) {

        $lookup = $this->custom_auth_function($username, $password);

        if (!$lookup) {
            // authentication failed
            return false;
        } else {

            // authentication passed, now get local user record
            $User = ClassRegistry::init('User');
            $local = $User->find('first',array(
                'conditions' => array(
                    'User.username' => $username
                ),
            ));

            if (!$local) {
                // no local user record, register the user directly
                $user = $this->parse_auth_results($lookup);

                if ($user = $User->save($user)) {
                    // user saved in local database, ready to go
                    return $user['User'];
                } else {
                    // something failed in the save, fail auth
                    return false;
                }

            } else {
                // local user found, return the info
                return $local['User'];
            }
        }

        return false;

    }

    function custom_auth_function($username, $password) {

        /*
         * Do the authentication database lookup here.
         * LDAP, NIS, Security Key, whatever...
         *
         * Return the user record if auth succeeds.
         */

        /*
         * otherwise, return false
         */
        return false;

    }

    function parse_auth_results($lookup) {

        /*
         * Transform authentication database lookup into croogo
         * User record, and return that info.
         *
         * The below code is completely bogus, just an idea of
         * what you might need to do to get the user data formatted
         * into a proper croogo user record.
         */
        $user = array(
            'name' => $lookup['name'],
            'username' => $lookup['username'],
            'password' => '********',
            'role_id' => $lookup['primary_role'],
            'email' => $lookup['email'],
            'website' => $lookup['website'],
            'status' => 1,
        );

        return $user;
    }

}
