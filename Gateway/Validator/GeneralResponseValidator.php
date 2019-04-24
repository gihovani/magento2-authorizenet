<?php

namespace Gg2\Authorizenet\Gateway\Validator;

use Magento\Payment\Gateway\Validator\AbstractValidator;

class GeneralResponseValidator extends AbstractValidator
{
    public function validate(array $validationSubject)
    {
        $response = $validationSubject['response'];
        $isValid = true;
        $errorMessages = [];
        foreach ($this->getResponseValidators() as $validator) {
            $validatorResult = $validator($response);
            if (!$validatorResult[0]) {
                $isValid = $validatorResult[0];
                $errorMessages = array_merge($errorMessages, $validatorResult[1]);
            }
        }

        return $this->createResult($isValid, $errorMessages);
    }

    private function getResponseValidators()
    {
        return [
            function ($response) {
                return [
                    isset($response['transactionResponse']) && is_array($response['transactionResponse']),
                    [__('Authorize.NET error response')]
                ];
            },
            function ($response) {
                return [
                    isset($response['messages']['resultCode']) && 'Ok' === $response['messages']['resultCode'],
                    [$response['messages']['resultCode'][0]['text'] ?: __('Authorize.NET error response')]
                ];
            },
            function ($response) {
                return [
                    empty($response['transactionResponse']['errors']),
                    [$response['transactionResponse']['errors'][0]['errorText'] ?: __('Authorize.NET error response')]
                ];
            },
        ];
    }
}
