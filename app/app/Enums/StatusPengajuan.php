<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum StatusPengajuan: string
{
    use EnumToArray;

    case DITOLAK      = "DITOLAK";
    case PENDING      = "PENDING";
    case SUKSES       = "SUKSES";
}
