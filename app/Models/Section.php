<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function scopeWithSearch($query, $request)
    {
        if ($request->search ?? '') {
            $query->whereRaw('name like "%' . $request->search . '%"');
        }
    }

    public function section_teacher()
    {
        return $this->hasOne(SectionTeacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function seats()
    {
        return $this->hasMany(SectionSeat::class);
    }
}
