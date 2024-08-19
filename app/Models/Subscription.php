<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'Subscription';

    public function user(){
        return $this->belongsTo(WebsiteUser::class, 'user_id');
    }
}
