<?php

use Masoudi\Laravel\Visitors\Models\Visitor;

/**
 * Create Visitor model
 *
 * @return \ Masoudi\Laravel\Visitors\Models\Visitor
 */
function visitors(): \Illuminate\Database\Eloquent\Builder
{
    return Visitor::query();
}
