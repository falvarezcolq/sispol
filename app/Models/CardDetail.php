<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
    //

    protected $appends = ['points'];

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
        return $this->belongsTo(Fixture::class)->with('team1', 'team2', 'group');
    }

    protected function points(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->fixture || ! $this->fixture->played) {
                    return 0;
                }
                if( $this->gol_1 === null || $this->gol_2 === null) {
                    return 0;
                }

                $points = 0;

                // si acierta el resultado exacto
                if ($this->gol_1 === $this->fixture->gol_1 && $this->gol_2 === $this->fixture->gol_2) {
                    $points= 3;
                    return $points;
                } 

                // si acierta el resultado pero no el exacto
                $predicted_diff = $this->gol_1 - $this->gol_2;
                $actual_diff = $this->fixture->gol_1 - $this->fixture->gol_2;

                if (($predicted_diff > 0 && $actual_diff > 0) || ($predicted_diff < 0 && $actual_diff < 0) || ($predicted_diff === 0 && $actual_diff === 0)) {
                    $points = 1;
                }


                return $points;
            }
        );
    }
}
