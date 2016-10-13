<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

interface UserMapper
{
    public function findByName(string $query) : UserCollection;
    public function findByEmail(string $query) : UserCollection;
    public function findByUsername(string $query) : UserCollection;
    public function findByCity(string $query) : UserCollection;
}
