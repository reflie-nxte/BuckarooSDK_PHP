<?php

require('../bootstrap.php');

use Buckaroo\Buckaroo;
use Buckaroo\Resources\Constants\Gender;

$buckaroo = new Buckaroo($_ENV['BPE_WEBSITE_KEY'], $_ENV['BPE_SECRET_KEY']);

//** START Create Duo Combined */
$subscriptions = $buckaroo->payment('subscriptions')->manually()->createCombined([
    'includeTransaction'        => false,
    'transactionVatPercentage'  => 5,
    'configurationCode'         => 'xxxxx',
    'email'                     => 'test@buckaroo.nl',
    'rate_plans'        => [
        'add'        => [
            'startDate'         => carbon()->format('Y-m-d'),
            'ratePlanCode'      => 'xxxxxx',
        ]
    ],
    'phone'                     => [
        'mobile'                => '0612345678'
    ],
    'debtor'                    => [
        'code'          => 'xxxxxx'
    ],
    'person'                    => [
        'firstName'         => 'John',
        'lastName'          => 'Do',
        'gender'            => Gender::FEMALE,
        'culture'           => 'nl-NL',
        'birthDate'         => carbon()->subYears(24)->format('Y-m-d')
    ],
    'address'           => [
        'street'        => 'Hoofdstraat',
        'houseNumber'   => '90',
        'zipcode'       => '8441ER',
        'city'          => 'Heerenveen',
        'country'       => 'NL'
    ]
]);

$response = $buckaroo->payment('ideal')->combine($subscriptions)->pay([
    'invoice'       => uniqid(),
    'amountDebit' => 10.10,
    'issuer' => 'ABNANL2A'
]);
//** END Create Duo Combined */

//** START Create Triple Combined */
$subscriptions = $buckaroo->payment('subscriptions')->manually()->createCombined([
    'includeTransaction'        => false,
    'transactionVatPercentage'  => 5,
    'configurationCode'         => 'xxxxx',
    'email'                     => 'test@buckaroo.nl',
    'rate_plans'        => [
        'add'        => [
            'startDate'         => carbon()->format('Y-m-d'),
            'ratePlanCode'      => 'xxxxxx',
        ]
    ],
    'phone'                     => [
        'mobile'                => '0612345678'
    ],
    'debtor'                    => [
        'code'          => 'xxxxxx'
    ],
    'person'                    => [
        'firstName'         => 'John',
        'lastName'          => 'Do',
        'gender'            => Gender::FEMALE,
        'culture'           => 'nl-NL',
        'birthDate'         => carbon()->subYears(24)->format('Y-m-d')
    ],
    'address'           => [
        'street'        => 'Hoofdstraat',
        'houseNumber'   => '90',
        'zipcode'       => '8441ER',
        'city'          => 'Heerenveen',
        'country'       => 'NL'
    ]
]);

$paypal_extra_info = $buckaroo->payment('paypal')->manually()->extraInfo([
    'amountDebit' => 10,
    'invoice' => uniqid(),
    'customer'  => [
        'name'      => 'John Smith'
    ],
    'address'   => [
        'street'       => 'Hoofstraat 90',
        'street2'       => 'Street 2',
        'city'          => 'Heerenveen',
        'state'         => 'Friesland',
        'zipcode'       => '8441AB',
        'country'       => 'NL'
    ],
    'phone'             => [
        'mobile'        => '0612345678'
    ]
]);

$response = $buckaroo->payment('paypal')->combine($subscriptions)->combine($paypal_extra_info)->pay([
    'amountDebit' => 10,
    'invoice' => uniqid()
]);
//** END Create Triple Combined */