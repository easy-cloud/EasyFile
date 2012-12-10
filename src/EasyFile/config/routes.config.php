<?php
namespace EasyFile;
return array(
    'router' => array(
        'routes' => array(
            'filemanager' => array(
                'type'      => 'Literal',
                'options'   => array(
                    'route'     => '/filemanager',
                    'defaults'  => array(
                        '__NAMESPACE__' => 'EasyFile\Controller',
                        'controller'    => 'EasyFile',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'download' => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/download/:file',
                            'defaults'  => array(
                                '__NAMESPACE__' => 'EasyFile\Controller',
                                'controller'    => 'File',
                                'action'        => 'getfile',
                            ),
                            'constraints' => array(
                                'file' => '.*',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'directory' => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/directory/:directory',
                            'defaults'  => array(
                                '__NAMESPACE__' => 'EasyFile\Controller',
                                'controller'    => 'EasyFile',
                                'action'        => 'index',
                            ),
                            'constraints' => array(
                                'directory' => '.*',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'remove' => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/remove/:file',
                            'defaults'  => array(
                                '__NAMESPACE__' => 'EasyFile\Controller',
                                'controller'    => 'File',
                                'action'        => 'removefile',
                            ),
                            'constraints' => array(
                                'file' => '.*',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'thumbnail' => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/thumbnail/:width/:height[/:type][/:rounded]/:file',
                            'defaults'  => array(
                                '__NAMESPACE__' => 'EasyFile\Controller',
                                'controller'    => 'File',
                                'action'        => 'getthumbnail',
                            ),
                            'constraints' => array(
                                'width' => '[0-9]*',
                                'height' => '[0-9]*',
                                'type' => '(crop|fit)',
                                'rounded' => '[0-9]*',
                                'file' => '.*',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
        ),
    ),
);
