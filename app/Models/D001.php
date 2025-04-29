<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class D001 extends Model
{
    public $table = 'd001';
    protected $primaryKey = 'D001_Id';
    public function d001a(): HasOne
    {
        return $this->hasOne(D001A::class, 'D001A_D001_Id', 'D001_Id');
    }
    public function d049(): HasOne
    {
        return $this->hasOne(D049::class, 'D049_D001_Id', 'D001_Id');
    }
}
