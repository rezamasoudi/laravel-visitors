<?php

namespace Masoudi\Laravel\Visitors\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static Visitor range(\DateTime $startDateTime, ?\DateTime $endDateTime = null)
 * @method static Visitor platform(string $platform)
 * @method static Visitor browser(string $browser)
 * @method static Visitor ipStarts(string $ip)
 * @method static Visitor ipEnds(string $ip)
 * @method static Visitor referrers(...$refers)
 * @method static Visitor paths(...$paths)
 * @method static Visitor authId(int $authId)
 */
class Visitor extends Model
{
    protected $table = 'visitors';

    protected $fillable = [
        'visitable',
        'visitable_id',
        'auth_id',
        'ip',
        'referrer',
        'user_agent',
        'path',
    ];

    /**
     * Scope visitable class
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $visitable
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisitable(Builder $query, string $visitable)
    {
        return $query->where('visitable', $visitable);
    }

    /**
     * Scope visitable id
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $visitableId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisitableId(Builder $query, int $visitableId)
    {
        return $query->where('visitable_id', $visitableId);
    }

    /**
     * Scope date range
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \DateTime $startDateTime
     * @param \DateTime $endDateTime
     * @return Visitor
     */
    public function scopeRange(Builder $query, DateTime $startDateTime, ?DateTime $endDateTime = null)
    {
        $query = $query->where('created_at', '>=', Carbon::parse($startDateTime));

        // Add end time condition if defined
        if ($endDateTime) {
            $query->where('created_at', '<=', Carbon::parse($endDateTime));
        }

        return $query;
    }

    /**
     * Scope visitor platform
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $platform
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePlatform(Builder $query, string $platform)
    {
        return $query->where('user_agent', 'REGEXP', $platform);
    }

    /**
     * Scope visitor browser
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $browser
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBrowser(Builder $query, string $browser)
    {
        return $query->where('user_agent', 'REGEXP', $browser);
    }

    /**
     * Scope IP Starts With
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $ip
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIpStarts(Builder $query, string $ip)
    {
        return $query->where('ip', 'LIKE', "{$ip}%");
    }

    /**
     * Scope IP Ends With
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $ip
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIpEnds(Builder $query, string $ip)
    {
        return $query->where('ip', 'LIKE', "%{$ip}");
    }

    /**
     * Scope Referrer
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $referrers
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReferrers(Builder $query, ...$refers)
    {
        return $query->where('referer', 'REGEXP', implode("|", $referrers));
    }

    /**
     * Scope Paths
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $paths
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaths(Builder $query, ...$paths)
    {
        return $query->where('path', 'REGEXP', implode("|", $paths));
    }

    /**
     * Scope Auth ID
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $authId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAuthId(Builder $query, $authId)
    {
        return $query->where('visitable_id', $authId);
    }
}
