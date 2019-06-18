<?php

namespace App\Extensions;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Str;

class DarlingUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return;
        }

        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value) {
            if (!Str::contains($key, 'password')) {
                $query->orWhere($key, $value);
            }
        }

        return $query->first();
    }
}
