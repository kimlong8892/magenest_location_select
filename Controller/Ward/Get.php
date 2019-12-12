<?php


namespace Magenest\Location\Controller\Ward;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Get extends Action
{
    protected $resultPageFactory;
    private $jsonResultFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $jsonResultFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $idDistrict = $this->_request->getParam('id');
        $json = file_get_contents('https://thongtindoanhnghiep.co/api/district/' . $idDistrict . '/ward');
        $result = $this->jsonResultFactory->create();
        $result->setData($json);
        return $result;
    }
}