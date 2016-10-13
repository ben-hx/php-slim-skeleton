<?php

declare (strict_types = 1);

namespace BenHx\Api\Models\User;

interface UserRepository
{
    public function create(string $username, string $password, string $firstName, string $lastName, string $email) : User;
    public function update(User $user);
    public function findByUsername(string $username);
    public function findById(string $id);
    public function getAll() : UserCollection;
}