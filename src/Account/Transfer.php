<?php

namespace Acme\CsvProcessor\Account;

/**
 * Class Transfer
 * Every entity represent single transfer item
 * @package Acme\CsvProcessor\Account
 */
class Transfer
{
    /** @var Account */
    private $fromAccount;

    /** @var Account */
    private $toAccount;

    /** @var float */
    private $amount;

    /** @var string */
    private $currency;

    /** @var string */
    private $comment;

    /** @var string */
    private $status;

    /** @var ?string */
    private $error;

    /**
     * @return Account
     */
    public function getFromAccount(): Account
    {
        return $this->fromAccount;
    }

    /**
     * @param Account $fromAccount
     * @return Transfer
     */
    public function setFromAccount(Account $fromAccount): Transfer
    {
        $this->fromAccount = $fromAccount;
        return $this;
    }

    /**
     * @return Account
     */
    public function getToAccount(): Account
    {
        return $this->toAccount;
    }

    /**
     * @param Account $toAccount
     * @return Transfer
     */
    public function setToAccount(Account $toAccount): Transfer
    {
        $this->toAccount = $toAccount;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Transfer
     */
    public function setAmount(float $amount): Transfer
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Transfer
     */
    public function setCurrency(string $currency): Transfer
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Transfer
     */
    public function setComment(string $comment): Transfer
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return TransferStatus
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Transfer
     */
    public function setStatus(string $status): Transfer
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @param string $error
     * @return Transfer
     */
    public function setError(string $error): Transfer
    {
        $this->error = $error;
        return $this;
    }
}