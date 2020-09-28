<?php


namespace App\Resources;


class PostResourcesClass
{
    /**
     * Метод формирования JSON Ответа
     * @param $item
     * @return array
     */
    public function returnJson($item)
    {
        return [
            "id"    => $item->_id,
            "title" => $item->title
        ];
    }
}