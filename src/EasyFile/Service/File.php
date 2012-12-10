<?php

namespace EasyFile\Service;
use DutchBridge\Service\AbstractService;

class File extends AbstractService
{
    protected $dir = __DIR__;

    protected $mainDirectory = "/../../files/uploads/";

    protected $fileInfo;

    protected $fileInfoNeat;

    protected $file;


    public function fileInfo()
    {
        if (!$this->fileInfo) {
            $this->fileInfo = new \finfo(FILEINFO_MIME_TYPE);
        }

        return $this->fileInfo;
    }

    public function fileInfoNeat()
    {
        if (!$this->fileInfoNeat) {
            $this->fileInfoNeat = new \finfo();
        }

        return $this->fileInfoNeat;
    }

    public function file($file)
    {
        $file = $this->dir.$this->mainDirectory.$file;
        if($file && file_exists($file)){
            $this->file = $file;
        }elseif(!$this->file){
            $this->file = $this->dir."/../../files/icons/filenot_found.png";
        }

        return $this;
    }

    public function fileSize()
    {
        $filesize = filesize($this->file);
        $units = array("B","kB","MB","GB","TB","PB","EB","ZB","YB");
        $c=0;
        $result = array();
        $result['units']='';
        foreach ($units as $index => $unit) {
            if ( ( $filesize / pow(1024, $index) ) >= 1) {
                $result["bytes"] = $filesize / pow(1024, $index);
                $result["units"] = $unit;
                $c++;
            }
            if(!isset($result['bytes'])){ 
                $result['bytes'] = $filesize;
            }
            $return=number_format($result["bytes"], 2) . " " . $result["units"];
        }

        return $return;
    }
    public function getContent()
    {
        return file_get_contents($this->file);
    }

    public function getFileType()
    {
        return $this->fileInfo()->file($this->file);
    }

    public function getFileTypeNeat()
    {
        $result = $this->fileInfoNeat()->file($this->file);
        $result = explode(",", $result);
        $result = str_replace("data", "", $result[0]);
        if(!$result){
            $result = $this->getFileType();
        }
        return $result;
    }

    public function getFile()
    {
        $result['type']    = $this->getFileType();
        $result['content'] = $this->getContent();

        return $result;
    }

    public function removeFile($file)
    {
        if(@unlink($file)){
            return true;
        }
        return false;
    }
}
