<?php


namespace Magenest\Location\Controller\Ward;


class Get extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    private $jsonResultFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $idDistrict = $this->_request->getParam('id');
        $json = file_get_contents('https://thongtindoanhnghiep.co/api/district/'.$idDistrict.'/ward');
        $result = $this->jsonResultFactory->create();
        $result->setData($json);
        return $result;
    }
}