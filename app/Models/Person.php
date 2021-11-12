<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'people';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['first_name', 'last_name'];
    protected $hidden = ['deleted_at'];
    protected $dates = ['deleted_at'];

    /*************************************
     ********** MODIFICATIONS ************
     ************************************/
    public function getFullNameAttribute(): string
    {
        return sprintf('%s %s', ucfirst($this->first_name), ucfirst($this->last_name));
    }

    /*************************************
     *********** RELATIONS ***************
     ************************************/
    public function relation(): HasOne
    {
        return $this->hasOne(Relation::class);
    }
}
