<?php

namespace Gg2\Authorizenet\Gateway\Request;

use Gg2\Authorizenet\Gateway\Config;
use Magento\Payment\Gateway\Request\BuilderInterface;

class RequestBuilder implements BuilderInterface
{
    /**
     * @var BuilderInterface
     */
    private $builder;
    /**
     * @var Config
     */
    private $config;

    public function __construct(BuilderInterface $builder, Config $config)
    {
        $this->builder = $builder;
        $this->config = $config;
    }

    public function build(array $buildSubject)
    {
        return [
            'createTransactionRequest' => [
                'merchantAuthentication' => [
                    'name'           => $this->config->getApiLoginId(),
                    'transactionKey' => $this->config->getTransactionKey()
                ],
                'transactionRequest'     => $this->builder->build($buildSubject)
            ]
        ];
    }
}
