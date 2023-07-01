<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_ip',
        'connection_time',
        'http_verb',
        'endpoint_called',
    ];

   
}
