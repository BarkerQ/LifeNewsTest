<?php

namespace App\Resources;


class LiveResourcesClass
{
    /**
     * Метод формирования JSON Ответа
     * @param $return
     * @return array
     */
    public function returnJson($return)
    {
        return [
            "id"    => empty($return) ? 0 : 1,
            "title" => empty($return) ? "Error" : "Success"
        ];
    }
}