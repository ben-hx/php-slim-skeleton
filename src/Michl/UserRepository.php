<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class UserRepository
{
    /** @var UserMapper */
    private $mapper;

    /**
     * @param UserMapper $mapper
     */
    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function findByNameEmailCityUsername(string $query) : UserCollection
    {
        return $this->mapper->findByCity($query)
            ->addAll($this->mapper->findByEmail($query))
            ->addAll($this->mapper->findByName($query))
            ->addAll($this->mapper->findByUsername($query));
    }
}
