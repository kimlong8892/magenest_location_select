<?php

namespace Magenest\Location\Block;

use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\View\Element\Template;

class Location extends Template
{
    private $jsonResultFactory;
    protected $jsonHelper;
    protected $_customerSession;

    public function __construct(
        Template\Context $context,
        JsonFactory $jsonResultFactory,
        Data $jsonHelper,
        SessionFactory $customerSession,
        array $data = []
    ) {
        $this->jsonResultFactory = $jsonResultFactory;
        $this->jsonHelper = $jsonHelper;
        $this->_customerSession = $customerSession->create();
        parent::__construct($context, $data);
    }

    public function getCity()
    {
        $json = file_get_contents('https://thongtindoanhnghiep.co/api/city');
        $array = $this->jsonHelper->jsonDecode($json);

        return $array['LtsItem'];
    }
}
