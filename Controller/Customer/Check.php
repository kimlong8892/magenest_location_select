<?php


namespace Magenest\Location\Controller\Customer;
class Check extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    private $jsonResultFactory;
    protected $_customerSession;
    protected $addressRepository;
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
        if($this->_customerSession->isLoggedIn())
        {
            $customer = $this->_customerSession->getCustomer();
            $customerAddress = [];
            forEach($customer->getAddresses() as $address)
                $customerAddress[] = $address->toArray();
            if(count($customerAddress) == 0)
                $customerAddress[0] = 'no-address';
            $result = $this->jsonResultFactory->create();
            $result->setData($customerAddress[0]);
            return $result;
        }
        else
        {
            $result = $this->jsonResultFactory->create();
            $result->setData(['guest']);
            return $result;
        }
    }
}