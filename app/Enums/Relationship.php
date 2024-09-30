<?php

namespace App\Enums;

enum Relationship: string
{
    case Parent = 'parent';
    case Spouse = 'spouse';
    case Sibling = 'sibling';
    case Child = 'child';
    case Other = 'other';
}
