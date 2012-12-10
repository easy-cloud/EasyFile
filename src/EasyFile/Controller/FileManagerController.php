<?php
namespace EasyFile\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FileManagerController extends AbstractActionController
{
    protected $fileManagerService;

    public function getFileManagerService()
    {
        if (!$this->fileManagerService) {
            $this->fileManagerService=$this->getServiceLocator()->get('FileManager.service');
        }

        return $this->fileManagerService;
    }

    public function indexAction()
    {
        return new viewModel(
            array(
                'list' => $this->getFileManagerService()->listAll($this->getEvent()->getRouteMatch()->getParam('directory')),
            )
        );
    }
}
