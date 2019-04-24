<?php

namespace Gg2\Authorizenet\Gateway\Http;

use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Payment\Gateway\Http\ClientException;
use Magento\Payment\Gateway\Http\ClientInterface;
use Magento\Payment\Gateway\Http\ConverterException;
use Magento\Payment\Gateway\Http\ConverterInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Model\Method\Logger;

class Client implements ClientInterface
{
    /**
     * @var ZendClientFactory
     */
    private $clientFactory;
    /**
     * @var ConverterInterface
     */
    private $converter;
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(ZendClientFactory $clientFactory, Logger $logger, ConverterInterface $converter = null)
    {
        $this->clientFactory = $clientFactory;
        $this->logger = $logger;
        $this->converter = $converter;
    }

    public function placeRequest(TransferInterface $transferObject)
    {
        $client = $this->clientFactory->create();
        $log = [
            'request_uri' => $transferObject->getUri(),
            'request'     => $this->converter
                ? $this->converter->convert($transferObject->getBody())
                : $transferObject->getBody()
        ];
        $result = [];
        try {
            $client->setConfig($transferObject->getClientConfig());
            $client->setMethod($transferObject->getMethod());
            $client->setRawData($transferObject->getBody(), 'application/json');
            $client->setHeaders($transferObject->getHeaders());
            $client->setUrlEncodeBody($transferObject->shouldEncode());
            $client->setUri($transferObject->getUri());

            $response = $client->request();
            $result = $this->converter ? $this->converter->convert($response->getBody()) : [$response->getBody()];
            $log['response'] = $result;
        } catch (\Zend_Http_Exception $exception) {
            throw new ClientException(__($exception->getMessage()));
        } catch (ConverterException $exception) {
            throw $exception;
        } finally {
            $this->logger->debug($log);
        }
        return $result;
    }

}
