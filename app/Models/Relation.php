<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relation extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $fillable = ['spouse_id', 'mother_id', 'father_id'];
    protected $visible = ['spouse_id', 'mother_id', 'father_id', 'spouse', 'mother', 'father'];
    protected $primaryKey = 'person_id';

    /******************************************
     ************* RELATIONS ******************
     *****************************************/
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function spouse(): HasOne
    {
        return $this->hasOne(Person::class, 'id', 'spouse_id');
    }

    public function mother(): HasOne
    {
        return $this->hasOne(Person::class, 'id', 'mother_id');
    }

    public function father(): HasOne
    {
        return $this->hasOne(Person::class, 'id', 'father_id');
    }
}
