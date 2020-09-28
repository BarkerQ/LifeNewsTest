<?php


namespace App\Helpers;


class CheckIdBlockClass
{
    /**
     * Метод проверки сущестования ID поста.
     * @param $block
     * @return null
     */
    public static function checkIdBlock($block)
    {
        if (empty($block->compiled->_id)) {
            if (empty($block->compiled->content->_id)) {
                return null;
            } else {
                return $block->compiled->content->_id;
            }
        } else {
            return $block->compiled->_id;
        }
    }
}