<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Rest\Controller\SignUp' => 'Rest\Controller\SignUpController',
            'Rest\Controller\SignIn' => 'Rest\Controller\SignInController',
            'Rest\Controller\Reminder' => 'Rest\Controller\ReminderController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/sign-up[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Rest\Controller\SignUp',
                    ),
                ),
            ),
            'sign-in' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/sign-in[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Rest\Controller\SignIn',
                    ),
                ),
            ),
            'reminder' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/reminder[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Rest\Controller\Reminder',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array( //Add this config
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);