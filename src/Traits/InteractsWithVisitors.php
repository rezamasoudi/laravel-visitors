<?php

namespace Masoudi\Laravel\Visitors\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Masoudi\Laravel\Visitors\Models\Visitor;

/**
 * @method static Visitor visitors()
 * @method Visitor visitors()
 */
trait InteractsWithVisitors
{
    /**
     * Handle dynamic static method calls into the model.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if ($method == 'visitors') {
            return (new static)->createVisitor();
        }

        return (new static)->$method(...$parameters);
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
     * Visit Model
     */
    public function visit(?Authenticatable $user = null, ?Request $request = null)
    {
        $user = $user ?? resolve(Authenticatable::class);
        $request = $request ?? resolve(Request::class);

        Visitor::create([
            'visitable' => static::class,
            'visitable_id' => $this->id,
            'auth_id' => $user?->id,
            'ip' => $request->ip(),
            'referer' => $request->header('referer'),
            'user_agent' => $request->userAgent(),
            'path' => $request->path(),
        ]);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param string $method
     * @param array $parameters
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
}
