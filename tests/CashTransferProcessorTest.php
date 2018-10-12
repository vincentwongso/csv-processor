<?php

namespace Acme\CsvProcessorTest;

use PHPUnit\Framework\TestCase;
use Acme\CsvProcessor\Processor\CashTransfer;
use Acme\CsvProcessor\Processor\InvalidInputException;
use Acme\CsvProcessor\Account\AccountService;
use Acme\CsvProcessor\Account\AccountNotFoundException;

class CashTransferProcessorTest extends TestCase
{
    /** @var CashTransfer */
    private $processor;

    public function setUp()
    {
        $accountMockDataRepo = new AccountMockDataRepository();
        $accountService = new AccountService();
        $this->processor = new CashTransfer($accountMockDataRepo, $accountService);
    }

    public function testCashTransferSuccess()
    {
        $input = ['198000', '123599', '30', 'AUD', 'Management Fee'];
        $expectedOutput = [198000, 123599, 30.0, 'AUD', 'Management Fee', 'Successful', ''];

        $output = $this->processor->process($input);
        $this->assertSame($expectedOutput, $output);
    }

    public function testCashTransferAccountNotFound()
    {
        $input = ['198001', '123599', '30', 'AUD', 'Management Fee'];

        $this->expectException(AccountNotFoundException::class);
        $this->processor->process($input);
    }

    public function testCashTransferInvalidCurrency()
    {
        $input = ['200198', '300210', '250', 'USD', 'Cash Transfer'];
        $expectedOutput = [200198, 300210, 250.0, 'USD', 'Cash Transfer', 'Error', 'Invalid currency in account 300210'];

        $output = $this->processor->process($input);
        $this->assertSame($expectedOutput, $output);
    }

    public function testCashTransferInvalidInput()
    {
        $input = ['198000', '123599', '30', 'Management Fee'];

        $this->expectException(InvalidInputException::class);
        $this->processor->process($input);
    }

    public function testCashTransferInvalidFromAccountDataType()
    {
        $input = ['ABC', '123599', '30', 'USD', 'Management Fee'];

        $this->expectException(InvalidInputException::class);
        $this->processor->process($input);
    }

    public function testCashTransferInvalidToAccountDataType()
    {
        $input = ['198000', 'DEF', '30', 'USD', 'Management Fee'];

        $this->expectException(InvalidInputException::class);
        $this->processor->process($input);
    }

    public function testCashTransferInvalidAmountDataType()
    {
        $input = ['198000', '123599', 'USD30', 'USD', 'Management Fee'];

        $this->expectException(InvalidInputException::class);
        $this->processor->process($input);
    }
}