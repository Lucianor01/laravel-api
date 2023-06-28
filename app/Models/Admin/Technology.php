<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    protected $table = 'technologies';

    protected $fillable = ['name', 'slug'];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
