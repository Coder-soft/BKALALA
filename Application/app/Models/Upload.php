<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'main_filename',
        'file_id',
        'file_path',
        'file_type',
        'file_size',
        'method',
        'views',
        'downloads',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
