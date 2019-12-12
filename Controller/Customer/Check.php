<?php

namespace Magenest\Location\Controller\Customer;

use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Check extends Action
{
    protected $resultPageFactory;
    private $jsonResultFactory;
    protected $_customerSession;
    protected $addressRepository;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $jsonResultFactory,
        SessionFactory $customerSession
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        $customer = $this->_customerSession->create();
        if ($customer->isLoggedIn()) {
            $customer = $customer->getCustomer();
            $customerAddress = [];
            foreach ($customer->getAddresses() as $address) {
                $customerAddress[] = $address->toArray();
            }
            if (count($customerAddress) == 0) {
                $customerAddress[0] = 'no-address';
            }
            $result = $this->jsonResultFactory->create();
            $result->setData($customerAddress[0]);
            return $result;
        } else {
            $result = $this->jsonResultFactory->create();
            $result->setData(['guest']);
            return $result;
        }
    }
}
