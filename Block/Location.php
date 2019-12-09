<?php


namespace Magenest\Location\Block;
use Magento\Framework\View\Element\Template;

class Location extends Template
{
    public function __construct(
        Template\Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
    }


    public function getCity()
    {
        $json = file_get_contents('https://thongtindoanhnghiep.co/api/city');
        $array = json_decode($json);
        return $array;
    }

}