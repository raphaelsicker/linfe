<?php


namespace App\Externals;


use App\Externals\Traits\FindTrait;

class MarcaApi
{
    public const URL_FIND = 'marca/#id';

    use FindTrait;
}
