<?php

namespace Acme\CsvProcessor\Account;


interface DataRepositoryInterface
{
    public function findById($id);
}