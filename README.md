# CSV Processor
The purpose of this application is to read csv file, process according specific business rule (implemented via Processor class), and write the resulting output.


At the moment there is only one processor that is `Cash Transfer Type`.
If you need to add new processor class simply create the class under processor folder and make sure the class implement `ProcessorInterface`.

## System Requirements  

- PHP >= 7.1
- Composer

## Installation

Get the code by either cloning the repository or download the zip folder.

Go to the directory and run composer install.

```bash
$ composer install
```

## Testing

It uses PHPUnit for testing.
To run the tests, simply run the following command from the project folder:

```bash
$ composer test
```

## Running

There are 2 ways to run the application.

1. **Process csv file by specifying the location of the csv and processor type.**
```bash
$ php app.php --type=CashTransfer ./data/uploads/test.csv
```
Currently there is only one processor type which is `CashTransfer` processor. So when we add a new type, e.g: cash adjustment processor. We can simply change the type to `--type=CashAdjustment`, of course with the assumption that we have implemented `CashAdjusment` class.

For demonstration purposes, 2 test files are provided in the project directory: `./data/uploads`.

Currently the output directory is hardcoded to `./data/results` directory. For the future it can be moved to the cli option similar to input file or separate config file. 


2. **Process csv file via Queue.**
```bash
$ php app.php
```

If we didn't pass any option and argument the script will try to get the next item from the Queue (currently only mock object).
 
The idea is to implement the queue with AWS SQS but currently `QueueHelper` only return mock data.

If the queue is not empty, it will process the next in queue but if there is no item in the queue it will not do anything. 
It assume that the queue is populated by other application (e.g user/staff member upload csv document via web UI).

The queue item consist of the processor type and also the csv file location. Once an item is processed from the queue it will be removed from the queue. 

So this second approach is the one that is going to be used by the cron task (every 5 minutes).


## Mock Data
Since this project is not connected to any database or web service to get account details.

We use `AccountMockDataRepository` with hardcoded data in this class.

The idea is if in the future we want to connect to real application we simply create new DataRepository that implements the DataRepositoryInterface. The implementation detail can be anything (e.g: database or web service).

## Assumptions
1. The application assumes that the underlying business logic like cash transfer, invalid currency logic, csv file validation, etc will not be implemented literally. 
But for the purpose of testing we've created a few supporting mock class like `AccountService` to simulate transfer and to add the `Invalid Currency` logic. The CSV input file validation logic are very simple and it only relies on the examples given in the test instructions.
2. The application assumes that the Csv Processor will be able to process the csv file quickly (under 5 minutes) and not memory intensive.
3. The application assumes that the input filename is unique and the output filename is always the same and the only thing that is different is the directory (`./data/results` folder for output and `./data/uploads` folder for input).


## Future Ideas
The solution is implemented with specific time limit(~ 3 hours) but the readme is written afterwards, so there are a few things that can be improved further.


1. The entry point of the application `./app.php` is a bit messy since I leave it last. For future improvement, I will definitely yse use symfony's `Console Component` for the cli implementation.
2. Properly implement the Queue service with SQS. 
3. Store the application config in .env file. Currently output folder is still hardcoded in the code, it's better to move this to a separate config file, like .env file.
4. Create proper Dockerfile to setup the docker environment. I have started this but not yet finished because of the time constraint.
5. Depending on how the other processor logic, if there are lots of common functions between different processors, it might be best to implement it using Factory Pattern or Abstract Factory Pattern.