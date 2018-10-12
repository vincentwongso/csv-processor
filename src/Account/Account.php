<?php
namespace Acme\CsvProcessor\Account;

/**
 * Class Account
 * @package Acme\CsvProcessor\Account
 */
class Account
{
    /** @var integer */
    private $id;

    /** @var float */
    private $balance;

    /** @var string */
    private $currency;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Account
     */
    public function setId(int $id): Account
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     * @return Account
     */
    public function setBalance(float $balance): Account
    {
        $this->balance = $balance;
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
     * @return Account
     */
    public function setCurrency(string $currency): Account
    {
        $this->currency = $currency;
        return $this;
    }
}