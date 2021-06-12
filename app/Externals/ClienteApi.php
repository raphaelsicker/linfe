<?php


namespace App\Externals;


use App\Externals\Traits\FindTrait;

class ClienteApi
{
    public const URL_FIND = 'cliente/#id/';

    use FindTrait;
}
