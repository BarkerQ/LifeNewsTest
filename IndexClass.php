<?php

namespace Main\Test;


use App\Interfaces\IndexInterface;
use App\Services\LiveClientClass;


include('App\Interfaces\IndexInterface.php');
include('App\Services\LiveClientClass.php');


class IndexClass extends LiveClientClass implements IndexInterface
{
    /**
     * Метод записи данных в cvs
     * @return array
     */
    function index() : array
    {
        return $this->writeData();
    }
}

$y = new IndexClass();
var_dump($y->index());