<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSlug
{
    public function incrementSlug($slug)
    {
        $originalSlug = $slug;

        $count = 2;

        while($this->whereSlug($slug)->exists()) {
            $slug = "${originalSlug}-" . $count++;
        }

        return $slug;
    }
}
