<?php
namespace Acme\CsvProcessor\Processor;

interface ProcessorInterface
{
    function process(array $input) : array;
}