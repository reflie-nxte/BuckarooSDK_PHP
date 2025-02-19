<?php
/*
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * It is available through the world-wide-web at this URL:
 * https://tldrlegal.com/license/mit-license
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to support@buckaroo.nl so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact support@buckaroo.nl for more information.
 *
 * @copyright Copyright (c) Buckaroo B.V.
 * @license   https://tldrlegal.com/license/mit-license
 */

namespace Tests\Buckaroo;

use Buckaroo\BuckarooClient;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class BuckarooTestCase extends TestCase
{
    protected BuckarooClient $buckaroo;
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(getcwd());
        $dotenv->load();

        $this->buckaroo = new BuckarooClient($_ENV['BPE_WEBSITE_KEY'], $_ENV['BPE_SECRET_KEY']);

        parent::__construct();
    }
}
