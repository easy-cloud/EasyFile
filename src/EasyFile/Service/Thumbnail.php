<?php

namespace EasyFile\Service;
use DutchBridge\Service\AbstractService;
use Imagick;

class Thumbnail extends AbstractService
{
    protected $dir = __DIR__;

    protected $mainDirectory = "/../../files/uploads/";

    protected $cacheDirectory = "/../../files/cache/";

    protected $fileService;

    protected $file;

    public function str_lreplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

    public function getFileService()
    {
        if (!$this->fileService) {
            $this->fileService=$this->getServiceLocator()->get('File.service');
        }

        return $this->fileService;
    }

    public function file($file)
    {
        if(file_exists($this->dir.$this->mainDirectory.$file)){
            $this->file = $this->dir.$this->mainDirectory.$file;
        }else{
            $this->file = $this->dir."/../../files/icons/filenot_found.png";
        }

        return $this->file;
    }

    public function cacheDirectory()
    {
        return $this->dir.$this->cacheDirectory;
    }

    public function getCacheFile(array $data)
    {
        // return false;
        $directory = $this->cacheDirectory();
        if(isset($data['thumbnail'])){
            $directory .= 'thumbnail/';
            if(!is_dir($directory)){
               return false;
            }
            if(isset($data['width'])&&!is_dir($directory .= $data['width'].'/')){
                return false;
            }
            if(isset($data['height'])&&!is_dir($directory .= $data['height'].'/')){
                return false;
            }
            if(isset($data['type'])&&!is_dir($directory .= $data['type'].'/')){
                return false;
            }
            if(isset($data['rounded'])&&$data['rounded']&&!is_dir($directory .= $data['rounded'].'/')){
                return false;
            }
            if(file_exists($directory.$data['file'])){
                return file_get_contents($directory.$data['file']);
            }else{
                return false;
            }
        }
    }

    public function createCacheDirectory(array $data)
    {
        $directory = $this->cacheDirectory();
        if(isset($data['thumbnail'])){
            $directory .= 'thumbnail/';
            if(!is_dir($directory)){
                mkdir($directory);
            }
            if(isset($data['width'])&&!is_dir($directory .= $data['width'].'/')){
                mkdir($directory);
            }
            if(isset($data['height'])&&!is_dir($directory .= $data['height'].'/')){
                mkdir($directory);
            }
            if(isset($data['type'])&&!is_dir($directory .= $data['type'].'/')){
                mkdir($directory);
            }
            if(isset($data['rounded'])&&$data['rounded']&&!is_dir($directory .= $data['rounded'].'/')){
                mkdir($directory);
            }
        }
        $returndir = $directory;
        if($dirs = explode("/", $data['file'])){
            $dirs = array_slice($dirs, 0, -1);
            foreach($dirs as $dir){
                if(!is_dir($directory .= $dir.'/')){
                    mkdir($directory);
                }
            }
        }
        return $returndir;
    }

    public function makeThumbnail(array $params)
    {
        $params['thumbnail'] = true;
        $info = pathinfo($this->file($params['file']));
        $extension = (isset($info['extension'])?$info['extension']:'');
        $file = $params['file'];
        $params['file'] = $this->str_lreplace($extension, "png", $params['file']);
        if (!isset($params['width'])) {
            $params['width'] = 100;
        }
        if (!isset($params['height'])) {
            $params['height'] = 100;
        }
        if (!isset($params['type'])) {
            $params['type'] = "crop";
        }
        if (!isset($params['rounded'])) {
            $params['rounded'] = false;
        }
        $cache = $this->getCacheFile($params);
        if($cache){
            $result['content'] = $cache;
            $result['type'] = 'image/png';
            return $result;
        }
        $type=$this->getFileService()->file($file)->getFileType();
        $type=explode("/", $type);
        // var_dump($type);
        try{
            $imagick = new Imagick($this->file($file));
            if(isset($type[1])&&$type[1]==="vnd.adobe.photoshop"){
                $imagick->flattenImages();
            }
        } catch (\Exception $e){
            try{
                if(isset($type['1'])){
                    $imagick = new Imagick($this->dir."/../../files/icons/".$type['1'].".png");
                }else{
                    $imagick = new Imagick($this->dir."/../../files/icons/".$type['0'].".png");
                }
            } catch (\Exception $e){
                try{
                    $imagick = new Imagick($this->dir."/../../files/icons/".$type['0'].".png");
                } catch (\Exception $e){
                    $imagick = new Imagick($this->dir."/../../files/icons/fileicon_bg.png");
                }
            }
        }
        $imagick->setImageFormat("png");
        if($params['type']==="crop"){
            $imagick->cropThumbnailImage($params['width'],$params['height']);
        }else{
            $imagick->ThumbnailImage($params['width'],$params['height']);
        }
        if($params['rounded']){
            $imagick->roundCorners($params['rounded'],$params['rounded']);
        }
        $result['content'] = $imagick;
        try{
            $imagick->writeImage($this->createCacheDirectory($params).$params['file']);
        } catch(\Exception $e){
            throw new \Exception($e);
        }
        $result['type'] = 'image/png';

        return $result;
    }

    public function getThumbnail($params)
    {
        $image=$this->makeThumbnail($params);

        return $image;
    }
}