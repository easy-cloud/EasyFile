<?php
namespace EasyFile;
return array(
    'service_manager'=>array(
        'factories' => array(
            'FileManager.service'=> function () {
                return new Service\FileManager();
            },
            'File.service'=> function () {
                return new Service\File();
            },
            'Directory.service'=> function () {
                return new Service\Directory();
            },
            'Thumbnail.service'=> function () {
                return new Service\Thumbnail();
            },
        ),
    ),
);
