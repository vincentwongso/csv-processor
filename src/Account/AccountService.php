<?php

namespace Acme\CsvProcessor\Account;

/**
 * Class AccountService
 * Assumption: This class simply a mock of how the account system works.
 * The real implementation should be proper web service call or atomic database operation.
 */
class AccountService
{

    /**
     * Transfer a specific amount from an account to another account
     * Assumption: The logic of currency transfer itself is simply checking
     * if the transfer currency is the same with fromAccount currency and toAccount currency
     *
     * @param Transfer $transfer
     * @return Transfer
     */
    public function processTransfer(Transfer $transfer) : Transfer
    {
        $fromAccount = $transfer->getFromAccount();
        $toAccount = $transfer->getToAccount();
        $transferCurrency = $transfer->getCurrency();
        if (!$this->isValidCurrency($fromAccount, $transferCurrency) || !$this->isValidCurrency($toAccount, $transferCurrency)) {
            $transfer->setStatus(TransferStatus::ERROR);
            $invalidAccountId = !$this->isValidCurrency($fromAccount, $transferCurrency) ? $fromAccount->getId() : $toAccount->getId();
            $transfer->setError('Invalid currency in account ' . $invalidAccountId);
        } else {
            $transfer->setStatus(TransferStatus::SUCCESS);
        }
        // Real implementation of the transfer can be done here

        return $transfer;
    }

    private function isValidCurrency(Account $account, $transferCurrency) : bool
    {
        return $account->getCurrency() === $transferCurrency;
    }
}