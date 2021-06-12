<?php


namespace App\Externals;


use App\Externals\Traits\FindTrait;

class GradeApi
{
    public const URL_FIND = 'grades/#id';

    use FindTrait;
}
