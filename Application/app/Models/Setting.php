<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'site_name',
        'logo',
        'favicon',
        'site_analytics',
        'home_heading',
        'home_descritption',
        'max_filesize',
        'onetime_uploads',
    ];

}
