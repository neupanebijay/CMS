<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'description','content','image','published_at','category_id'];

    public function imageDelete()
    {
        Storage::delete($this->image);
    }

    public function category()
    {
        
        // return $this->belongsTo('App\Category');
        /**
         * the above one is similar to the following one
         */
        return $this->belongsTo(Category::class);

    }
}
