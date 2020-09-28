<?php

namespace App\Helpers;


use App\Consts\ConstsClass;

include("App\Consts\ConstsClass.php");

class MainHelperClass
{
    /**
     * Метод запроса и сохранения JSON ответа.
     * @param $path
     * @return mixed
     */
    public function getData($path)
    {
        $info = file_get_contents(ConstsClass::url . $path);

        return json_decode($info);
    }
}
