<?php
namespace EasyFile\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class FileController extends AbstractActionController
{
    protected $fileService;

    protected $thumbnailService;

    public function getFileService()
    {
        if (!$this->fileService) {
            $this->fileService=$this->getServiceLocator()->get('File.service');
        }

        return $this->fileService;
    }

    public function getThumbnailService()
    {
        if (!$this->thumbnailService) {
            $this->thumbnailService=$this->getServiceLocator()->get('Thumbnail.service');
        }

        return $this->thumbnailService;
    }

    public function getthumbnailAction()
    {
        $params = $this->getEvent()->getRouteMatch()->getParams();
        $file = $this->getThumbnailService()->getThumbnail($params);
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', $file['type']);
        $response->setStatusCode(200);
        $response->setContent($file['content']);

        return $response;
    }

    public function getfileAction()
    {
        $file = $this->getEvent()->getRouteMatch()->getParam('file');
        $fileClass = new \EasyFile\Service\File();
        $fileClass->file($file);
        $file = $fileClass->getFile();
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', $file['type']);
        $response->setStatusCode(200);
        $response->setContent($file['content']);

        return $response;
    }

    public function removefileAction()
    {
        $file = $this->getEvent()->getRouteMatch()->getParam('file');
        $this->getFileService()->removeFile($file);
        return $this->redirect()->toRoute('filemanager');
    }
}
