<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'player_name',
        'game_date',
        'result',
        'progression',
        'missed_number',
        'player_answer',
    ];
}
