<?php

namespace Gg2\Authorizenet\Gateway;

use Magento\Framework\Exception\NotFoundException;
use Magento\Payment\Gateway\Config\ValueHandlerPool;

class Config
{
    /**
     * @var ValueHandlerPool
     */
    private $valueHandlerPool;

    public function __construct(ValueHandlerPool $valueHandlerPool)
    {
        $this->valueHandlerPool = $valueHandlerPool;
    }

    public function getGatewayUrl()
    {
        if ($this->isSandbox()) {
            return (string)$this->getGatewayUrl('gateway_url_sandbox');
        }
        return (string)$this->getValue('gateway_url');
    }

    public function isSandbox()
    {
        return (bool)$this->getValue('is_sandbox');
    }

    public function getGatewayHeaders()
    {
        return ['Content-Type' => 'application/json'];
    }

    public function getApiLoginId()
    {
        return (string)$this->getValue('api_login_id');
    }

    public function getTransactionKey()
    {
        return (string)$this->getValue('transaction_key');
    }

    private function getValue($field)
    {
        try {
            $handler = $this->valueHandlerPool->get($field);
            return $handler->handle(['field' => $field]);
        } catch (NotFoundException $exception) {
            return null;
        }
    }
}
