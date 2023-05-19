<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // allow mass assignment, need this to add a gig to the database
        // OR go into AppServiceProvider.php -> boot() and add Model::unguard()
    // protected $fillable = ['title', 'company', 'location', 'website', 'tags', 'email', 'description'];

    // public function scopeFilter($query, array $filters) {
    //     dd($filters['tag']);
    // }
    //  for the tags
    public function scopeFilter($query, array $filters) {
        if($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }
}
