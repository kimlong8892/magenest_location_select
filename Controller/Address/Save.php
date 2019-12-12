<?php


namespace Magenest\Location\Controller\Address;


use Magento\Customer\Model\AddressFactory;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Save extends Action
{
    protected $addressFactory;
    protected $_customerSession;
    protected $addressRepository;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        AddressFactory $addressFactory,
        SessionFactory $customerSession
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->addressRepository = $addressFactory->create();
        $this->_customerSession = $customerSession->create();
        parent::__construct($context);
    }

    public function execute()
    {
        $city = $this->_request->getParam('city');
        $district = $this->_request->getParam('district');
        $ward = $this->_request->getParam('ward');

        $customerData = $this->_customerSession->getCustomer();

        $customerAddress = [];
        forEach ($customerData->getAddresses() as $address)
            $customerAddress[] = $address->toArray();
        $addressId = null;
        if (count($customerAddress) != 0)
            $addressId = $customerAddress[0]["entity_id"];
        if ($addressId != null) {
            $address = $this->addressRepository->load($addressId);
            $address->setData('city', $city);
            $address->setData('region', $district);
            $address->setData('street', $ward);
            $address->save();
        } else {
            $address = $this->addressRepository;
            $address->setCustomerId($customerData->getId())
                ->setFirstname($customerData->getData('firstname'))
                ->setLastname($customerData->getData('lastname'))
                ->setCountryId('VN')
                ->setPostcode('31000')
                ->setCity($city)
                ->setTelephone('0038511223344')
                ->setStreet($ward)
                ->setIsDefaultBilling('1')
                ->setIsDefaultShipping('1')
                ->setSaveInAddressBook('1')
                ->setData('region', $district);
            $address->save();
        }
    }
}