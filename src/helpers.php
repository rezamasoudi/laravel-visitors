<?php

use Masoudi\Laravel\Visitors\Models\Visitor;

/**
 * Create Visitor model
 * 
 * @return \ Masoudi\Laravel\Visitors\Models\Visitor
 */
function visitors(): Visitor
{
    return (new Visitor);
}
