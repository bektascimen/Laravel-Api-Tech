<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'device';
    protected $guarded = [];

    public function application()
    {
        return $this->hasOne(Application::class, 'id', 'appId')->whereStatus(1);
    }

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'languageId')->whereStatus(1);
    }

    public function os()
    {
        return $this->hasOne(OperatingSystem::class, 'id', 'osId')->whereStatus(1);
    }
}
