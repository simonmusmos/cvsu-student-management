<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'student_number',
        'password',
        'section_id',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function scopeWithSearch($query, $request)
    {
        if ($request->search ?? '') {
            $query->whereRaw('CONCAT(first_name," ",last_name) like "%' . $request->search . '%"');
        }
    }
}
