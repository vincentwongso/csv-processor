<?php
namespace Acme\CsvProcessorTest;

use PHPUnit\Framework\TestCase;
use Acme\CsvProcessor\Account\Account;
use Acme\CsvProcessor\Account\Transfer;
use Acme\CsvProcessor\Account\TransferStatus;
use Acme\CsvProcessor\Account\AccountService;

class AccountServiceTest extends TestCase
{
    /** @var Account */
    private $fromAccount;
    /** @var Account */
    private $toAccount;

    public function setUp()
    {
        $this->fromAccount = new Account();
        $this->fromAccount->setId(1);
        $this->fromAccount->setCurrency('AUD');
        $this->fromAccount->setBalance(400.00);


        $this->toAccount = new Account();
        $this->toAccount->setId(2);
        $this->toAccount->setCurrency('AUD');
        $this->toAccount->setBalance(500.00);
    }

    public function testTransferFromOneAccountToAnotherSuccessfully()
    {
        $transferAmount = 50.00;
        $transferCurrency = 'AUD';
        $transfer = new Transfer();
        $transfer->setFromAccount($this->fromAccount)
            ->setToAccount($this->toAccount)
            ->setAmount($transferAmount)
            ->setCurrency($transferCurrency)
            ->setComment('Management Fee');

        $accountService = new AccountService();
        $transferResult = $accountService->processTransfer($transfer);

        $this->assertEquals($transferResult->getStatus(), TransferStatus::SUCCESS);
    }

    public function testTransferFailedInvalidCurrency()
    {
        $transferAmount = 50.00;
        $transferCurrency = 'USD';
        $transfer = new Transfer();
        $transfer->setFromAccount($this->fromAccount)
            ->setToAccount($this->toAccount)
            ->setAmount($transferAmount)
            ->setCurrency($transferCurrency)
            ->setComment('Management Fee');

        $accountService = new AccountService();
        $transferResult = $accountService->processTransfer($transfer);
        $this->assertEquals($transferResult->getStatus(), TransferStatus::ERROR);
    }
}