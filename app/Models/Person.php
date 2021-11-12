<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'people';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['first_name', 'last_name'];
    protected $hidden = ['id', 'deleted_at'];
    protected $visible = ['relations', 'first_name', 'last_name'];
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
    public function relations(): HasMany
    {
        return $this->hasMany(Relation::class);
    }

    /*************************************
     *********** CRUD ********************
     ************************************/
    public static function createPerson(array $fields)
    {
        return self::create($fields);
    }

    /*************************************
     *********** HELPERS *****************
     ************************************/
    public function connectRelationToPerson(array $input)
    {
        foreach ($input['relations'] as $relation) {
            $relative = Relation::firstOrCreate(
                ['person_id' => $this->id],
                ['relative_id' => $relation['relative_id'], 'relationship' => $relation['relationship']]
            );

            if ($relative->relationship == 'spouse') {
                $relative->relations()->firstOrCreate([
                    'person_id' => $relative->id,
                    'relative_id' => $this->id,
                    'relationship' => 'spouse',
                ]);
            }
        }
    }
}
