<?php

namespace App;

use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use Laravel\Spark\CanJoinTeams;
use Laravel\Spark\Spark;
use Laravel\Spark\User as SparkUser;
use Illuminate\Support\Collection;

/**
 * Class User
 * @package App
 *
 * @method static Collection onlyOnline()
 */
class User extends SparkUser
{
    use Searchable, Friendable, CanJoinTeams;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'online'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'date',
        'uses_two_factor_auth' => 'boolean',
        'online' => 'boolean'
    ];

    /**
     * Return only online Users.
     *
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeOnlyOnline($query)
    {
        return $query->where('online', '=', true);
    }
}
