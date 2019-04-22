<?php

namespace Gg2\Authorizenet\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;

class RequestBuilder implements BuilderInterface
{
    /**
     * @var BuilderInterface
     */
    private $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function build(array $buildSubject)
    {
        return [
            'createTransactionRequest' => [
                'merchantAuthentication' => [
                    'name'           => '2YA8Fn4gMy9J',
                    'transactionKey' => '276d9THeh45zxUaL'
                ],
                'transactionRequest'     => [
                    'transactionType' => $this->builder->build($buildSubject)
                ]
            ]
        ];
    }
}
