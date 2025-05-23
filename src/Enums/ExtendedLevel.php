<?php

namespace Pvguerra\LaravelTrakt\Enums;

enum ExtendedLevel: string
{
    case Images = 'images';
    case Full = 'full';
    case FullImages = 'full,images';
    case Metadata = 'metadata';
}
