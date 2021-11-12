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
    protected $fillable = ['person_id', 'relative_id', 'relationship'];
    protected $visible = ['relative_id', 'relationship', 'spouse', 'mother', 'father'];
    protected $primaryKey = 'person_id';

    protected const RELATIONSHIPS = [
        'SPOUSE' => 'spouse',
        'FATHER' => 'father',
        'MOTHER' => 'mother',
    ];

    /******************************************
     ************* RELATIONS ******************
     *****************************************/
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function spouse(): HasOne
    {
        return $this->hasOne(Person::class, 'id', 'relative_id')
            ->where('relationship', self::RELATIONSHIPS['SPOUSE']);
    }

    public function mother(): HasOne
    {
        return $this->hasOne(Person::class, 'id', 'relative_id')
            ->where('relationship', self::RELATIONSHIPS['MOTHER']);
    }

    public function father(): HasOne
    {
        return $this->hasOne(Person::class, 'id', 'relative_id')
            ->where('relationship', self::RELATIONSHIPS['FATHER']);
    }
}
