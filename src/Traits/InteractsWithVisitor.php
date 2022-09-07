<?php

namespace Masoudi\Laravel\Visitors\Traits;

use Masoudi\Laravel\Visitors\Models\Visitor;

/**
 * @method static \Masoudi\Laravel\Visitors\Models\Visitor visitors()
 * @method \Masoudi\Laravel\Visitors\Models\Visitor visitors()
 */
trait InteractsWithVisitor
{
    /**
     * Visit Model
     */
    public function visit()
    {
        Visitor::create([
            'visitable'     =>  static::class,
            'visitable_id'     =>  $this->id,
            'auth_id'       =>  auth()?->id(),
            'ip'            =>  $_SERVER['REMOTE_ADDR'] ?? null,
            'referrer'      =>  $_SERVER['HTTP_REFERER'] ?? null,
            'user_agent'    =>  $_SERVER['HTTP_USER_AGENT'] ?? null,
            'path'          =>  $_SERVER['REQUEST_URI'] ?? null
        ]);
    }

    /**
     * Create Visitors Query
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function createVisitor()
    {
        $baseQuery = Visitor::visitable(static::class);
        if (isset($this->id)) {
            $baseQuery = $baseQuery->visitableId($this->id);
        }

        return $baseQuery;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($method == 'visitors') {
            return $this->createVisitor();
        }

        if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }

        if ($resolver = (static::$relationResolvers[get_class($this)][$method] ?? null)) {
            return $resolver($this);
        }

        return $this->forwardCallTo($this->newQuery(), $method, $parameters);
    }

    /**
     * Handle dynamic static method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if ($method == 'visitors') {
            return (new static)->createVisitor();
        }

        return (new static)->$method(...$parameters);
    }
}
