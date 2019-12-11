<?php


namespace Magenest\Location\Controller\District;


class Get extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    private $jsonResultFactory;
    protected $_customerSession;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Magento\Customer\Model\SessionFactory $customerSession
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->_customerSession = $customerSession->create();
        parent::__construct($context);
    }
    public function execute()
    {
        $a = $this->_customerSession->isLoggedIn();
        $idCity = $this->_request->getParam('id');
        $json = file_get_contents('https://thongtindoanhnghiep.co/api/city/'.$idCity.'/district');
        $result = $this->jsonResultFactory->create();
        $result->setData($json);
        return $result;
    }
}