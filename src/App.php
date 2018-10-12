<?php
namespace Acme\CsvProcessor;

use Acme\CsvProcessor\Processor\ProcessorInterface;

/**
 * Class App
 * The main app that will handle reading csv file, processing and writing the result.
 * @package Acme\CsvProcessor
 */
class App
{

    /** @var ProcessorInterface */
    private $processor;

    public function __construct(ProcessorInterface $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Run and process the input csv file and output to destination folder
     * @param $inputFilepath
     * @param $outputFilePath
     * @throws FileException
     * @throws \Exception
     */
    public function run($inputFilepath, $outputFilePath) : void
    {
        if (!file_exists($inputFilepath)) {
            throw new FileException('Input file not found: ' . $inputFilepath);
        }

        $inputFileHandler = fopen($inputFilepath, 'r');
        if ($inputFileHandler === false) {
            throw new FileException('Unable to open input file: ' . $inputFilepath);
        }

        if (file_exists($outputFilePath)) {
            //always overwrite
            @unlink($outputFilePath);
        }

        $outputFileHandler = fopen($outputFilePath, 'a');
        if ($outputFileHandler === false) {
            throw new FileException('Unable to open output file: ' . $outputFilePath);
        }
        $line = 1;
        while (($data = fgetcsv($inputFileHandler)) !== false) {
            try {
                $results = $this->processor->process($data);
                fputcsv($outputFileHandler, $results);
            } catch(\Exception $e) {
                throw new \Exception("Error processing line $line: " . $e->getMessage());
            }
        }
        fclose($inputFileHandler);
        fclose($outputFileHandler);
    }
}