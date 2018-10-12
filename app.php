<?php
require __DIR__.'/vendor/autoload.php';

use Acme\CsvProcessor\App;
use Acme\CsvProcessor\Account\AccountService;
use Acme\CsvProcessor\Processor\CashTransfer;
use Acme\CsvProcessorTest\AccountMockDataRepository;
use Acme\CsvProcessor\Queue\QueueHelper;

$shortopts = 't::';
$longopts = ['type::'];

$options = getopt($shortopts, $longopts);


$accountMockDataRepo = new AccountMockDataRepository();
$accountService = new AccountService();

//default processor
$processor = new CashTransfer($accountMockDataRepo, $accountService);

$inputFilePath = '';

if (isset($options['type']) && isset($argv[2])) {
    $inputFilePath = $argv[2];
    $processorClassName = "Acme\\CsvProcessor\\Processor\\" . $options['type'];
} else {
    $queue = new QueueHelper();
    $item = $queue->getNextItem();
    if ($item !== null) {
        $processorClassName = "Acme\\CsvProcessor\\Processor\\" . $item['type'];
        $inputFilePath = $item['filepath'];
    }
}

if (class_exists($processorClassName)) {
    $processor =  new $processorClassName($accountMockDataRepo, $accountService);
}

if ($inputFilePath !== '') {
    $pathParts = pathinfo($inputFilePath);
    $outputFilePath = __DIR__.'/data/results/'.$pathParts['filename'].'.'.$pathParts['extension'];

    $app = new App($processor);
    try {
        $app->run($inputFilePath, $outputFilePath);
    } catch (\Exception $e) {
        print $e->getMessage();
    }
}
