<?php


namespace Magenest\Location\Observer;
use Magento\Framework\Event\ObserverInterface;

class CustomerLogin implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $customer = $observer->getEvent()->getCustomer();

    }
}