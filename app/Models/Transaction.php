<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "category_id",
        "transaction_date",
        "amount",
        "description",
        "user_id"
    ];


    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }
    
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }


    // mutators
    public function setAmountAttribute($value){
        $this->attributes['amount'] = $value*100;
    }

    public function setTransactionDateAttribute($value){
        $this->attributes['transaction_date']= Carbon::parse($value)->format('Y-m-d');
    }


    protected static function booted(){
       if(auth()->check()){
            static::addGlobalScope('by_user', function (Builder $builder) {
                $builder->where('user_id', auth()->id());
            });
       }
    }
}
