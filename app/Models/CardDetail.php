<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
    //

    protected $fillable = [
        'card_id',
        'fixture_id',
        'gol_1',
        'gol_2',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class)->with('team1', 'team2','group');
    }

    
}
