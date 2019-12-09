<?php


namespace Magenest\Location\Controller\Ward;


class Get extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory
        $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $idDistrict = $this->_request->getParam('id');
        $json = file_get_contents('https://thongtindoanhnghiep.co/api/district/'.$idDistrict.'/ward');
        print_r($json);
    }
}