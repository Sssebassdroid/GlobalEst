<?php

namespace App\Enums;

enum TourOrderBy: string
{
    case LATEST = 'latest';
    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';
}
