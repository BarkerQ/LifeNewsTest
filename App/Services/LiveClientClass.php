<?php

namespace App\Services;


use App\Helpers\MainHelperClass;
use App\Resources\LiveResourcesClass;
use App\Resources\BlockInfoResourcesClass;
use App\Resources\PostResourcesClass;
use App\Consts\ConstsClass;


include("App\Helpers\MainHelperClass.php");
include("App\Resources\LiveResourcesClass.php");
include("App\Resources\BlockInfoResourcesClass.php");
include("App\Resources\PostResourcesClass.php");


class LiveClientClass extends MainHelperClass
{
    protected $jsonResources;
    protected $jsonResourcesBlock;
    protected $jsonResourcesPost;

    static $return = null;

    public function __construct()
    {
        $this->jsonResources        = new LiveResourcesClass();
        $this->jsonResourcesBlock   = new BlockInfoResourcesClass();
        $this->jsonResourcesPost    = new PostResourcesClass();
    }

    /**
     * Метод получения данных с API и формирование данных для записи в csv
     * @return array
     */
    public function writeData() : array
    {
        // Создаем файлы
        $writePosts = fopen(ConstsClass::filePost, ConstsClass::w);
        $writePost = fopen(ConstsClass::filePosts, ConstsClass::w);

        // Делаеем запрос в API и получаем список всех постов
        $getPosts = $this->getData(ConstsClass::pathLenta);

        // Проходим по каждому посту
        self::foreachPosts($getPosts, $writePost, $writePosts);

        // Закрываеем соединение
        fclose($writePosts);
        fclose($writePost);

        // Проверяем данные. Если запрос на получение постов ответил пустотой, выбиваем код 0, иначе все гуд
        return $this->jsonResources->returnJson(self::$return);
    }

    /**
     * Проходим по каждому посту и записываем в файлик. А так же, проходим по каждому блоку и создаем второй файл
     * @param object $getPosts Объект с постами
     * @param $writePost
     * @param $writePosts
     */
    private function foreachPosts($getPosts, $writePost, $writePosts) : void
    {
        // Записываем формат в наш поток.
        fprintf($writePosts, $this->utf8Format());
        fprintf($writePost, $this->utf8Format());

        // Записываем нужные нам хедеры для csv
        fputcsv($writePosts, ConstsClass::arrayPost, ConstsClass::semicolon);
        fputcsv($writePost, ConstsClass::arrayPosts, ConstsClass::semicolon);

        // Проходим по каждому блоку
        foreach ($getPosts->data as $item){

            // Делаем запрос на получение данных о конкретном посте
            $getPost = $this->getData($item->_id);

            // формируем массив данных для записи в файл
            self::$return = $this->jsonResourcesPost->returnJson($item);

            // Проходим по каждому блоку поста
            self::foreachPost($getPost, $writePost);

            // Записываем массив данных в файлик и ставим делитель, чтоб данные нее вписывались в одну строку.
            fputcsv($writePosts, self::$return, ConstsClass::semicolon);
        }
    }

    /**
     * Проходим по каждым блокам поста и формируем массив для записи в файл
     * @param object $getPost Объект с данными блока
     * @param $writePost
     */
    private function foreachPost($getPost, $writePost) : void
    {
        // Проходим по каждому блоку поста
        foreach ($getPost->data->blocks as $block) {
            // Формируем массив для записи
            $returnBlock = $this->jsonResourcesBlock->returnJson($block);

            fputcsv($writePost, $returnBlock, ConstsClass::semicolon);
        }
    }

    /**
     * Метод для пеереевода строки в UTF-8
     * @return string
     */
    private function utf8Format() : string
    {
        return chr(0xEF).chr(0xBB).chr(0xBF);
    }
}
