<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum StatusTagihan: string
{
    use EnumToArray;

    case BELUM_BAYAR = "BELUM_BAYAR";
    case LUNAS       = "LUNAS";
    case TERLAMBAT   = "TERLAMBAT";
}
