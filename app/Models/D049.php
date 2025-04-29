<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class D049 extends Model
{
    public $table = 'd049';
    protected $primaryKey = 'D049_Id';
    public function d009(): HasOne
    {
        return $this->hasOne(D009::class, 'D009_D049_Id', 'D049_Id');
    }
}
