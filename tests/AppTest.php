<?php
namespace Acme\CsvProcessorTest;

use PHPUnit\Framework\TestCase;
use Acme\CsvProcessor\App;
use Acme\CsvProcessor\FileException;
use Acme\CsvProcessor\Processor\CashTransfer;
use Acme\CsvProcessor\Account\AccountService;

class AppTest extends TestCase
{
    /** @var CashTransfer */
    private $processor;

    private $input = [
        ['198000','123599','30','AUD','Management Fee'],
        ['200198','300210','250','USD','Cash Transfer']
    ];

    private $expectedOutput = [
        ['198000','123599','30','AUD','Management Fee', 'Successful', ''],
        ['200198','300210','250','USD','Cash Transfer', 'Error', 'Invalid currency in account 300210']
    ];

    private $inputFilepath = __DIR__.'/data/uploads/test.csv';
    private $outputFilepath = __DIR__.'/data/results/test.csv';

    public function setUp()
    {
        $accountMockDataRepo = new AccountMockDataRepository();
        $accountService = new AccountService();
        $this->processor = new CashTransfer($accountMockDataRepo, $accountService);
        $fp = fopen($this->inputFilepath, 'w+');

        foreach ($this->input as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }

    public function tearDown()
    {
        @unlink($this->inputFilepath);
        @unlink($this->outputFilepath);
    }

    public function testProcessCashTransferCsvInputFileNotFound()
    {
        $inputFilepath = __DIR__.'/not_found.csv';
        $outputFilepath = __DIR__.'/not_found_output.csv';
        $app = new App($this->processor);
        $this->expectException(FileException::class);
        $app->run($inputFilepath, $outputFilepath);
    }

    public function testProcessCashTransferCsvSuccessful()
    {
        $app = new App($this->processor);
        $app->run($this->inputFilepath, $this->outputFilepath);

        $results = [];
        $fp = fopen($this->outputFilepath, 'r');
        while (($data = fgetcsv($fp)) !== false) {
            $results[] = $data;
        }

        $this->assertSame($this->expectedOutput, $results);
    }
}