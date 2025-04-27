<?php

namespace App\Enums;

enum RecapStatus: string
{
    case TO = 'TO';
    case PROCESS = 'PROCESS';
    case DO = 'DO';
}
