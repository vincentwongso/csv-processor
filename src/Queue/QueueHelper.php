<?php

namespace Acme\CsvProcessor\Queue;

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

/**
 * Class QueueHelper
 * Implementation of Queue using AWS SQS
 * @package Acme\CsvProcessor\Queue
 */
class QueueHelper
{
    private $client;

    public function __construct()
    {
        $client = new SqsClient([
            'profile' => 'default',
            'region' => 'us-west-2',
            'version' => '2012-11-05'
        ]);

    }

    public function getNextItem()
    {
        return [
            'type' => 'CashTransfer',
            'filepath' => './data/uploads/test.csv'
        ];
    }
}