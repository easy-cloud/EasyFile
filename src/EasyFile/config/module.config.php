<?php
namespace EasyFile;
return array(
    'controllers' => array(
        'invokables' => array(
            'EasyFile\Controller\FileManager' => 'EasyFile\Controller\FileManagerController',
            'EasyFile\Controller\File' => 'EasyFile\Controller\FileController',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'orm_default' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../Entity')
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'filemanager' => __DIR__ . '/../../../view',
        ),
    ),
);
