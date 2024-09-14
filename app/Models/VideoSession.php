<?php

namespace App\Models;

use App\Enums\Purpose;
use App\Enums\Sexuality;
use App\Enums\VideoSessionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $team_size
 *
 * @property VideoSessionMember[] $members
 * @property VideoSessionTalk[] $talks
 */
class VideoSession extends Model
{
    protected $table = 'video_sessions';

    private ?array $_male = null;
    private ?array $_female = null;


    protected $casts = [
        'sexuality' => Sexuality::class,
        'purpose' => Purpose::class,
        'status' => VideoSessionStatus::class,
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i');
    }

    public function getStartedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i');
    }

    public function talks(): HasMany
    {
        return $this->hasMany(VideoSessionTalk::class, 'video_session_id', 'id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(VideoSessionMember::class, 'video_session_id', 'id')
            ->orderBy('position', 'asc');
    }

    public function getMaleTeam(): array
    {
        $this->composeTeams();
        return $this->_male;
    }

    public function getFemaleTeam(): array
    {
        $this->composeTeams();
        return $this->_female;
    }

    private function composeTeams()
    {
        if ($this->_male !== null) return;
        $this->_male = array_fill(0, $this->team_size, null);
        $this->_female = array_fill(0, $this->team_size, null);

        foreach ($this->members as $m) {
            if ($m->position < $this->team_size) {
                $this->_male[$m->position] = $m->user;
            } else {
                $this->_female[$m->position - $this->team_size] = $m->user;
            }
        }
    }
}
