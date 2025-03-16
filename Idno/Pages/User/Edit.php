<?php

    /**
     * Edit the user's profile
     */

namespace Idno\Pages\User {

    /**
     * Default class to serve the homepage
     */
    class Edit extends \Idno\Common\Page
    {

        // Handle GET requests to the entity

        function getContent()
        {
            $user = null;
            if (!empty($this->arguments[0])) {
                $user = \Idno\Entities\User::getByHandle($this->arguments[0]);
            }
            if (empty($user)) {
                $this->forward(); // Forward to 404 page if user is not found
                return;
            }
            if (!$user->canEdit()) {
                $this->deniedContent(); // Deny access if user cannot edit
                return;
            }

            $t = \Idno\Core\Idno::site()->template();
            $t->__(
                array(
                    'title' => \Idno\Core\Idno::site()->language()->_('Edit profile: %s', [$user->getTitle()]),
                    'body'  => $t->__(array('user' => $user))->draw('entity/User/edit')
                )
            )->drawPage();
        }

    }

}

