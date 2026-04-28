<?php

namespace App\Helpers;

class PaginateHelper
{
    public static function generateItemNumber($loop, $perPage, $currentPage)
    {
        return $loop->iteration + $perPage * ($currentPage - 1);
    }
}
