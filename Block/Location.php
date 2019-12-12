<?php

namespace Magenest\Location\Block;

use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Element\Template;

class Location extends Template
{
    private $jsonResultFactory;
    protected $json;
    protected $_customerSession;

    public function __construct(
        Template\Context $context,
        JsonFactory $jsonResultFactory,
        \Magento\Framework\Serialize\Serializer\Json $json,
        array $data = []
    ) {
        $this->jsonResultFactory = $jsonResultFactory;
        $this->json = $json;
        parent::__construct($context, $data);
    }

    public function getCity()
    {
        $json = file_get_contents('https://thongtindoanhnghiep.co/api/city');
        $array = $this->json->unserialize($json);
        return $array['LtsItem'];
    }
}
