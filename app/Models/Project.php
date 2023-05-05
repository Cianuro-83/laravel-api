<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['type', 'technologies'];

    protected $fillable=[
        'title',
        'slug',
        'customer',
        'description',
        'url',
        'type_id',
        'cover_image',
    ];
        
        public function type(){
            return $this->belongsTo(Type::class);
        }

        public function technologies(){
            return $this->belongsToMany(Technology::class);
        }

        public function getTechnologyIds(){
            return $this->technologies->pluck('id')->all();
        }

        public function getRelatedProjects(){
            return $this->type->projects()->where('id', '!=', $this->id)->get();
        }

        protected function coverPath(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return asset('storage/' . $attributes['cover_image']);
            }
        );
    }
    protected $appends = ['cover_path'];
}