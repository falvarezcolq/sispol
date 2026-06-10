<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    //

    protected $fillable = [
        'country_id_1',
        'country_id_2',
        'group_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'match_date',
        'gol_1',
        'gol_2',
        'played',
        'penalties',
        'penalties_gol_1',
        'penalties_gol_2',
    ];
    public function cardDetails()
    {
        return $this->hasMany(CardDetail::class);
    }

    // public function getTeamNamesAttribute()
    // {
    //     return $this->team1 . ' vs ' . $this->team2;
    // }

    public function team1()
    {
        return $this->belongsTo(Country::class, 'country_id_1');
    }

    public function team2()
    {
        return $this->belongsTo(Country::class, 'country_id_2');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    
}
