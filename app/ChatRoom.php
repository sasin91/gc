<?php

namespace App;

use App\Events\ChatRoom\ChatRoomCreated;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laravel\Spark\Spark;
use Laravel\Spark\Team;

/**
 * Class ChatRoom
 * @package App
 *
 * @method static Builder onlyPublic()
 * @method static Builder forTeam($team)
 * @method static Builder forTeams($teams)
 */
class ChatRoom extends Model
{
    protected $fillable = [
        'isPublic',
        'topic',
        'team_id',
        'user_id'
    ];

    protected $casts = [
        'isPublic'  =>  'boolean'
    ];

    /**
    * The event map for the model.
    *
    * Allows for object-based events for native Eloquent events.
    *
    * @var array
    */
    protected $events = [
        'created'   =>  ChatRoomCreated::class
    ];
    

    /**
     * Return only public Rooms.
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeOnlyPublic($query)
    {
        return $query->where('isPublic', true);
    }

    /**
     * @param Builder $query
     * @param Team|string|integer $team
     * @return mixed
     */
    public function scopeForTeam($query, $team)
    {
        $teamModel = Spark::teamModel();
        if ($team instanceof $teamModel) {
            return $query->where('team_id', $team->getKey());
        }

        if (is_string($team)) {
            return $query->where('team_id', Spark::team()
                                                ->where('name', $team)
                                                ->firstOrFail()
                                                ->getKey()
            );
        }

        return $query->where('team_id', $team);
    }

    /**
     * @param Builder $query
     * @param Collection|array $teams
     */
    public function scopeForTeams($query, $teams)
    {
       $ids = collect($teams)->transform(function ($team) {
           if ($team instanceof Team) {
               return $team->id;
           }

           return $team;
       });

       return $query->whereIn('team_id', $ids);
    }

    public function isPublic()
    {
        return (bool)$this->isPublic;
    }

    public function isPrivate()
    {
        return ! $this->isPublic();
    }

    public function publish()
    {
        $this->update(['isPublic' => true]);

        return $this;
    }

    public function unpublish()
    {
        $this->update(['isPublic' => false]);

        return $this;
    }

    public function team()
    {
        return $this->belongsTo(Spark::team());
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
