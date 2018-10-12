<?php

namespace Acme\CsvProcessorTest;

use Acme\CsvProcessor\Account\Account;
use Acme\CsvProcessor\Account\DataRepositoryInterface;
use Acme\CsvProcessor\Account\AccountNotFoundException;

/**
 * Class AccountMockDataRepository
 * Mock account data for testing since we're not using any database
 */
class AccountMockDataRepository implements DataRepositoryInterface
{
    private $accounts;

    public function __construct()
    {
        $account1 = new Account();
        $account1->setId(198000);
        $account1->setBalance(500);
        $account1->setCurrency('AUD');

        $account2 = new Account();
        $account2->setId(123599);
        $account2->setBalance(500);
        $account2->setCurrency('AUD');

        $account3 = new Account();
        $account3->setId(200198);
        $account3->setBalance(500);
        $account3->setCurrency('USD');

        $account4 = new Account();
        $account4->setId(300210);
        $account4->setBalance(500);
        $account4->setCurrency('AUD');


        $this->accounts = [
            $account1,
            $account2,
            $account3,
            $account4
        ];
    }

    /**
     * Find account by id
     * @param $id
     * @return Account
     * @throws AccountNotFoundException
     */
    public function findById($id) : ?Account
    {
        $results = array_filter($this->accounts, function(Account $account) use ($id) {
            return $account->getId() === $id;
        });
        if (count($results) > 0) {
            return array_pop($results);
        }
        throw new AccountNotFoundException("Account {$id} not found!");
    }
}