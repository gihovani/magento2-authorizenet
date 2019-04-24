<?php

namespace Gg2\Authorizenet\Gateway\Converter;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Payment\Gateway\Http\ConverterInterface;

class JsonToArray implements ConverterInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function convert($response)
    {
        // Fix for the Authorize.NET JSON response issue
        $response = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response);
        return $this->serializer->unserialize($response);
    }
}
