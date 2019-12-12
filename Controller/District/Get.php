<?php


namespace Magenest\Location\Controller\District;


use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Get extends Action
{
    protected $resultPageFactory;
    private $jsonResultFactory;
    protected $_customerSession;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $jsonResultFactory,
        SessionFactory $customerSession
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        $a = $this->_customerSession->create()->isLoggedIn();
        $idCity = $this->_request->getParam('id');
        $json = file_get_contents('https://thongtindoanhnghiep.co/api/city/' . $idCity . '/district');
        $result = $this->jsonResultFactory->create();
        $result->setData($json);
        return $result;
    }
}