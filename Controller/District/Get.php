<?php


namespace Magenest\Location\Controller\District;


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
        $idCity = $this->_request->getParam('id');
        $json = file_get_contents('https://thongtindoanhnghiep.co/api/city/'.$idCity.'/district');
        print_r($json);
    }
}