<?php

namespace App;

use App\Server;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Laravel\Spark\CanJoinTeams;
use Laravel\Spark\Spark;
use Laravel\Spark\User as SparkUser;

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

    public function isDev()
    {
        return Spark::developer($this->email);
    }

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

    public function servers()
    {
        return $this->belongsToMany(Server::class);
    }

    public function chatRooms()
    {
        return $this->belongsToMany(ChatRoom::class);
    }

    public function forums() 
    {
        return $this->hasManyThrough(Forum::class, Team::class);
    }

    public function forumThreads() 
    {
        return $this->hasMany(forumThread::class, 'author_id');
    }

    public function forumPosts() 
    {
        return $this->hasMany(ForumPost::class, 'author_id');
    }

    public function blogs() 
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
}
