<?php

namespace Core\Domain\Enum;

enum MediaStatus: int
{
    case PROCESSING = 0;
    case COMPLETEM = 1;
    case PENDING = 2;
}