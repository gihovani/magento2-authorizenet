<?php

namespace Gg2\Authorizenet\Gateway\Http;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;

class TransferFactory implements TransferFactoryInterface
{

    /**
     * @var TransferBuilder
     */
    private $transferBuilder;

    public function __construct(TransferBuilder $transferBuilder)
    {
        $this->transferBuilder = $transferBuilder;
    }

    public function create(array $request)
    {
        return $this->transferBuilder
            ->setUri('https://apitest.authorize.net/xml/v1/request.api')
            ->setMethod('POST')
            ->setBody(json_encode($request))
            ->setHeaders(['Content-Type' => 'application/json'])
            ->build();
    }
}
