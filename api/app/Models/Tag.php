<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'tags';

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
