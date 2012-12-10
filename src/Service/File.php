<?php

namespace FileManager\Service;

class File extends AbstractDutchBridgeService
{
    protected $mainDirectory = __DIR__."/../files";
    public function getFile($id=null)
    {
        if (!$id) {
            return $this->getRepository()->findAll();
        } else {
            return $this->getRepository()->find($id);
        }
    }

    public function listFiles($directory = null)
    {
        if ($directory) {

        } else {
            return scandir($this->mainDirectory);
        }

    }
}
