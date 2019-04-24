<?php

namespace Gg2\Authorizenet\Plugin\Payment\Block;

class Info
{
    const AUTH_CODE = 'auth_code';
    const AVS_RESULT_CODE = 'avs_result_code';
    const CVV_RESULT_CODE = 'cvv_result_code';
    const CAVV_RESULT_CODE = 'cavv_result_code';
    const ACCOUNT_NUMBER = 'account_number';
    const ACCOUNT_TYPE = 'account_type';
    const TEST_REQUEST = 'test_request';

    private $labels = [
        self::AUTH_CODE        => 'Auth Code',
        self::AVS_RESULT_CODE  => 'Address Verification Service (AVS)',
        self::CVV_RESULT_CODE  => 'Card Code Verification (CVV)',
        self::CAVV_RESULT_CODE => 'Cardholder Authentication Verification (CAVV)',
        self::ACCOUNT_NUMBER   => 'Account Number',
        self::ACCOUNT_TYPE     => 'Account Type',
        self::TEST_REQUEST     => 'Test Result'
    ];
    private $values = [
        self::AVS_RESULT_CODE => [
            'A' => 'The street address matched, but the postal code did not.',
            'B' => 'No address information was provided.',
            'E' => 'The AVS check returned an error.',
            'G' => 'The card was issued by a bank outside the U.S. and does not support AVS.',
            'N' => 'Neither the street address nor postal code matched.',
            'P' => 'AVS is not applicable for this transaction.',
            'R' => 'Retry — AVS was unavailable or timed out.',
            'S' => 'AVS is not supported by card issuer.',
            'U' => 'Address information is unavailable.',
            'W' => 'The US ZIP+4 code matches, but the street address does not.',
            'X' => 'Both the street address and the US ZIP+4 code matched.',
            'Y' => 'The street address and postal code matched.',
            'Z' => 'The postal code matched, but the street address did not.'
        ],
        self::CVV_RESULT_CODE => [
            'M' => 'CVV matched.',
            'N' => 'CVV did not match.',
            'P' => 'CVV was not processed.',
            'S' => 'CVV should have been present but was not indicated.',
            'U' => 'The issuer was unable to process the CVV check.',
        ],
        self::CAVV_RESULT_CODE => [
            '0' => 'CAVV was not validated because erroneous data was submitted.',
            '1' => 'CAVV failed validation.',
            '2' => 'CAVV passed validation.',
            '3' => 'CAVV validation could not be performed; issuer attempt incomplete.',
            '4' => 'CAVV validation could not be performed; issuer system error.',
            '5' => 'Reserved for future use.',
            '6' => 'Reserved for future use.',
            '7' => 'CAVV failed validation, but the issuer is available. Valid for U.S.-issued card submitted to non-U.S acquirer.',
            '8' => 'CAVV passed validation and the issuer is available. Valid for U.S.-issued card submitted to non-U.S. acquirer.',
            '9' => 'CAVV failed validation and the issuer is unavailable. Valid for U.S.-issued card submitted to non-U.S acquirer.',
            'A' => 'CAVV passed validation but the issuer unavailable. Valid for U.S.-issued card submitted to non-U.S acquirer.',
            'B' => 'CAVV passed validation, information only, no liability shift.',
        ]
    ];

    public function afterGetSpecificInformation(\Magento\Payment\Block\Info $subject, $result)
    {
        if ('gg2_authorizenet' === $subject->getData('methodCode')) {
            foreach ($this->labels as $key => $label) {
                if (array_key_exists($key, $result)) {
                    $value = $result[$key];
                    if (isset($this->values[$key][$value])) {
                        $value = $this->values[$key][$value];
                    }
                    $result[$label] = $value;
                    unset($result[$key]);
                }
            }
        }

        return $result;
    }
}
