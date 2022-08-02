<?php

namespace Buckaroo\Tests\Payments;

use Buckaroo\Tests\BuckarooTestCase;

class SofortTest extends BuckarooTestCase
{
    protected function setUp(): void
    {
        $this->paymentPayload = ([
            'invoice' => uniqid(),
            'amountDebit' => 10.10
        ]);
    }

    /**
     * @return void
     * @test
     */
    public function it_creates_a_sofort_payment()
    {
        $response = $this->buckaroo->method('sofortueberweisung')->pay($this->paymentPayload);

        $this->assertTrue($response->isPendingProcessing());
    }

}