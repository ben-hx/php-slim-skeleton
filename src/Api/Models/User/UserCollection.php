<?php

declare (strict_types = 1);

namespace BenHx\Api\Models\User;

use BenHx\Api\Util\AbstractCollection;

/**
 * Immutable User Collection.
 */
class UserCollection extends AbstractCollection
{
    public function add(User $user) : UserCollection
    {
        $users = clone $this;
        $users->collection[] = $user;

        return $users;
    }

    public function addAll(UserCollection $users) : UserCollection
    {
        $newUsers = clone $this;
        $newUsers->collection = array_merge($this->collection, $users->collection);

        return $newUsers;
    }
}
