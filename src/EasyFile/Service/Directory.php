<?php

namespace EasyFile\Service;
use DutchBridge\Service\AbstractService;

class Directory extends AbstractService
{
    protected $dir = __DIR__;

    protected $mainDirectory = "/../../files/uploads/";

    protected $directory;

    public function directory($directory)
    {
        $directory = $this->dir.$this->mainDirectory.$directory;
        if($directory && is_dir($directory)){
            $this->directory = $directory;
        }elseif(!$this->directory){
            throw new \Exception("No folder");
        }

        return $this;
    }

    public function directorySize()
    {
        $directorysize = 0; 
        foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->directory)) as $file){ 
            $directorysize+=$file->getSize(); 
        } 
        $units = array("B","kB","MB","GB","TB","PB","EB","ZB","YB");
        $c=0;
        foreach ($units as $index => $unit) {
            if ( ( $directorysize / pow(1000, $index) ) >= 1) {
                $result["bytes"] = $directorysize / pow(1000, $index);
                $result["units"] = $unit;
                $c++;
            }
            $return=number_format($result["bytes"], 2) . " " . $result["units"];
        }

        return $return;
    }
}
