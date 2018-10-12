<?php

namespace Acme\CsvProcessor\Processor;

/**
 * Class CashAdjustment
 *
 * The purpose of this class is simply to show that if in the future
 * we need a different rule for csv processor, we can just simply create a new class
 * that implements ProcessorInterface.
 */
class CashAdjustment implements ProcessorInterface
{
    public function process(array $input) : array
    {

    }
}