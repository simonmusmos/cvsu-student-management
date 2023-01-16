<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
    ];

    public function scopeWithSearch($query, $request)
    {
        if ($request->search ?? '') {
            $query->whereRaw('CONCAT(first_name," ",last_name) like "%' . $request->search . '%"');
        }
    }

    public function section_teacher()
    {
        return $this->hasMany(SectionTeacher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
