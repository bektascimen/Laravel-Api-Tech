<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndPoints extends Model
{
    use HasFactory;

    protected $table = '3rd_party_endpoints';
    protected $guarded = [];
}
