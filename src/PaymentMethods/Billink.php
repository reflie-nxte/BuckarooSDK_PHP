<?php

namespace Buckaroo\PaymentMethods;

use Buckaroo\Model\ServiceList;
use Buckaroo\Services\PayloadService;
use Buckaroo\Services\ServiceListParameters\ArticleParameters;
use Buckaroo\Services\ServiceListParameters\CustomerParameters;
use Buckaroo\Services\ServiceListParameters\DefaultParameters;
use Buckaroo\Transaction\Response\TransactionResponse;

class Billink extends PaymentMethod
{
    public const SERVICE_VERSION = 0;

    public function setPayServiceList(array $serviceParameters = [])
    {
        $serviceList =  new ServiceList(
            self::BILLINK,
            self::SERVICE_VERSION,
            'Pay'
        );

        $parametersService = new DefaultParameters($serviceList);
        $parametersService = new ArticleParameters($parametersService, $serviceParameters['articles'] ?? []);
        $parametersService = new CustomerParameters($parametersService, $serviceParameters['customer'] ?? []);
        $parametersService->data();

        $this->request->getServices()->pushServiceList($serviceList);

        return $this;
    }

    public function authorize($payload): TransactionResponse
    {
        $this->payload = (new PayloadService($payload))->toArray();
        $this->request->setPayload($this->getPaymentPayload());

        $serviceList = new ServiceList(
            self::BILLINK,
            self::SERVICE_VERSION,
            'Authorize'
        );

        $parametersService = new DefaultParameters($serviceList);
        $parametersService = new ArticleParameters($parametersService, $this->payload['serviceParameters']['articles'] ?? []);
        $parametersService = new CustomerParameters($parametersService, $this->payload['serviceParameters']['customer'] ?? []);
        $parametersService->data();

        $this->request->getServices()->pushServiceList($serviceList);

        return $this->postRequest();
    }

    public function paymentName(): string
    {
        return self::BILLINK;
    }

    public function serviceVersion(): int
    {
        return self::SERVICE_VERSION;
    }
}