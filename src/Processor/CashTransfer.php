<?php

namespace Acme\CsvProcessor\Processor;

use Acme\CsvProcessor\Account\AccountService;
use Acme\CsvProcessor\Account\DataRepositoryInterface;
use Acme\CsvProcessor\Account\Transfer;

/**
 * Class CashTransfer
 * Process cash transfer csv files.
 * @package Processor
 */
class CashTransfer implements ProcessorInterface
{
    private $dataRepo;
    private $accountService;

    public function __construct(DataRepositoryInterface $dataRepo, AccountService $accountService)
    {
        $this->dataRepo = $dataRepo;
        $this->accountService = $accountService;
    }

    /**
     * Process one line of entry
     *
     * @param array $input
     * @return array
     * @throws InvalidInputException
     */
    public function process(array $input) : array
    {
        $this->validateInput($input);
        $transfer = $this->convertArrayToTransfer($input);
        $transfer = $this->accountService->processTransfer($transfer);

        return $this->convertTransferToArray($transfer);
    }

    /**
     * Validate the input
     * Assumption: the current validation logic is very simple, it counts for the minimum items and basic data type check.
     *
     * @param $input
     * @throws InvalidInputException
     */
    private function validateInput($input) : void
    {
        if (count($input) !== 5 ) {
            throw new InvalidInputException('Cash Transfer input need to have 5 columns in the following order: From_Account, To_Account, Amount, Currency, Comment.');
        }
        if (intval($input[0]) === 0) {
            throw new InvalidInputException("Cash Transfer From_Account id must be a valid integer.");
        }
        if (intval($input[1]) === 0) {
            throw new InvalidInputException("Cash Transfer To_Account id must be a valid integer.");
        }
        if (floatval($input[2]) === 0.0) {
            throw new InvalidInputException("Cash Transfer Amount must be a valid decimal number.");
        }
    }

    /**
     * Convert from input array to TransferInput entity
     * @param array $input
     * @return Transfer
     */
    private function convertArrayToTransfer(array $input) : Transfer
    {
        $transfer = new Transfer();
        $fromAccount = $this->dataRepo->findById(intval($input[0]));
        $toAccount = $this->dataRepo->findById(intval($input[1]));
        $transfer->setFromAccount($fromAccount)
            ->setToAccount($toAccount)
            ->setAmount(floatval($input[2]))
            ->setCurrency($input[3])
            ->setComment($input[4]);
        return $transfer;
    }

    /**
     * Convert Transfer to array
     * @param Transfer $transfer
     * @return array
     */
    private function convertTransferToArray(Transfer $transfer) : array
    {
        return [
            $transfer->getFromAccount()->getId(),
            $transfer->getToAccount()->getId(),
            $transfer->getAmount(),
            $transfer->getCurrency(),
            $transfer->getComment(),
            $transfer->getStatus(),
            $transfer->getError() !== null ? $transfer->getError() : ''
        ];
    }
}