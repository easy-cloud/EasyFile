<?php
namespace FileManager;
return array(
    'controllers' => array(
        'invokables' => array(
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'orm_default' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Entity')
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'filemanager' => __DIR__ . '/../view',
        ),
    ),
);
