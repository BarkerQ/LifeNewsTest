<?php


namespace App\Resources;

use App\Helpers\CheckIdBlockClass;


include("App\Helpers\CheckIdBlockClass.php");


class BlockInfoResourcesClass
{
    /**
     * Метод формирования JSON Ответа
     * @param $block
     * @return array
     */
    public function returnJson($block)
    {
        return [
            "id"        => CheckIdBlockClass::checkIdBlock($block),
            "type"      => $block->type,
            "content"   => empty($block->content) ? null : md5($block->content)
        ];
    }
}