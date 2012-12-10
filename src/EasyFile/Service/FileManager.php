<?php

namespace EasyFile\Service;
use DutchBridge\Service\AbstractService;

class FileManager extends AbstractService
{
    protected $dir = __DIR__;

    protected $mainDirectory = "/../../files/uploads/";

    protected $fileService;

    protected $directoryService;

    public function getFileService()
    {
        if (!$this->fileService) {
            $this->fileService=$this->getServiceLocator()->get('File.service');
        }

        return $this->fileService;
    }

    public function getDirectoryService()
    {
        if (!$this->directoryService) {
            $this->directoryService=$this->getServiceLocator()->get('Directory.service');
        }

        return $this->directoryService;
    }

    public function listAll($directory = null)
    {
        $result = array();
        $dir = $this->dir.$this->mainDirectory.($directory?$directory.'/':'').'*';
        $list = glob($dir);
        foreach ($list as $index=>$item) {
            $full = $item;
            $item = str_replace(str_replace("*", "", $dir), "", $item);
            $file = ($directory?$directory.'/':'').$item;
            if (is_dir($full)) {
                $result['all'][$index]['name'] = $item;
                $result['all'][$index]['file'] = $file;
                $result['all'][$index]['size'] = $this->getDirectoryService()->directory($file)->directorySize();
                $result['all'][$index]['type'] = "directory";
                $result['all'][$index]['filetype'] = "Directory";
            } else {
                $result['all'][$index]['name'] = $item;
                $result['all'][$index]['size'] = $this->getFileService()->file($file)->fileSize();
                $result['all'][$index]['type'] = $this->getFileService()->getFileType();
                $result['all'][$index]['filetype'] = $this->getFileService()->getFileTypeNeat();
                $result['all'][$index]['file'] = $file;
            }

        }
        return $result; 

    }
}
