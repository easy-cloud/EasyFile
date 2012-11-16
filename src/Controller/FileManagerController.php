<?php
namespace FileManager\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FileManagerController extends AbstractActionController
{
    protected $FileService;
    
    public function getFileService()
    {
        if (!$this->FileService) {
            $this->FileService=$this->getServiceLocator()->get('File.service');
        }
        
        return $this->FileService;
    }
}
