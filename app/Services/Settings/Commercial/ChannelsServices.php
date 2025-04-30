<?php

namespace App\Services\Settings\Commercial;


use App\Models\GMP015;
use Illuminate\Database\Eloquent\Collection;

class ChannelsServices
{
    public function __construct(
        protected GMP015 $channels
    )
    {}
    public function channels(): Collection
    {
        return $this->channels->query()->get();
    }

}
