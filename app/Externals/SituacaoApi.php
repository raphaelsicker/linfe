<?php


namespace App\Externals;


use App\Externals\Traits\FindTrait;
use App\Externals\Traits\GetTrait;
use Carbon\Carbon;

class SituacaoApi
{
    public const URL_GET = 'situacao/';

    use GetTrait;
}
