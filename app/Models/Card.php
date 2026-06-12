<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['total_points'];

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'card_number',
        'balance',
        'card_type',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateCardNumber(): int
    {
        $lastCard = self::latest('id')->first();
        return $lastCard ? ((int) $lastCard->card_number) + 1 : 100234; // Starting from a base number
    }

    public function cardDetails()
    {
        return $this->hasMany(CardDetail::class)->with('fixture');
    }


    public function total_points(): int
    {
        return Attribute::make(
            get: function () {
                return $this->cardDetails->sum('points');
            }
        );
    }
    public function getTotalPointsAttribute(): int
    {
        return $this->cardDetails->sum('points');
    }


}
