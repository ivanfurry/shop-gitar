<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];        
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }    

    public function getImage()
    {
        if (!$this->img) {
            return asset('no-image.png');
        } else {
            return asset("storage/images/{$this->img}");
        }
    }
}
