<?php

// We need to tell Croogo about our event handlers. The event handlers
// are where we will insert our custom adapters into the CakePHP Auth
// Component's processing stream.
$config = array(
    'EventHandlers' => array(
        'AuthAdapter.AuthAdapterEventHandler' => array(
            'priority' => 20,
        ),
    ),
);

