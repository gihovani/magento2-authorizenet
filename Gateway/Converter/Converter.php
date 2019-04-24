<?php

namespace Gg2\Authorizenet\Gateway\Converter;

use Magento\Payment\Gateway\Http\ConverterInterface;

class Converter
{
    /**
     * @var ConverterInterface
     */
    private $converter;

    public function __construct(ConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function convert(array $request)
    {
        return $this->converter->convert($request);
    }
}
