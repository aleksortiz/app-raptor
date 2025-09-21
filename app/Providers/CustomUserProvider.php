<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;

class CustomUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
           (count($credentials) === 1 &&
            array_key_exists('password', $credentials))) {
            return;
        }

        // For the query, we will remove the password from the credentials array
        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value) {
            if (Str::contains($key, 'password')) {
                continue;
            }

            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } else {
                // Check if this is a nickname or email login
                if ($key === 'login') {
                    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $query->where('email', $value);
                    } else {
                        $query->where('nickname', $value);
                    }
                } else {
                    $query->where($key, $value);
                }
            }
        }

        return $query->first();
    }
}
