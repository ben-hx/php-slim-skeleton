<?php

declare (strict_types = 1);

namespace BenHx\Api\Models\User;

use BenHx\Api\Exceptions\FileNotWritableException;
use BenHx\Api\Exceptions\FileNotReadableException;
use BenHx\Api\Exceptions\ValidationException;

class UserFileRepository implements UserRepository
{
    /** @var \SplFileInfo */
    private $file;

    /**
     * @param \SplFileInfo $file
     *
     * @throws FileNotReadableException
     * @throws FileNotWritableException
     */
    public function __construct(\SplFileInfo $file)
    {
        $this->ensureFileIsReadable($file);
        $this->ensureFileIsWritable($file);

        $this->file = $file;
    }

    /**
     * @param \SplFileInfo $file
     *
     * @throws FileNotReadableException
     */
    private function ensureFileIsReadable(\SplFileInfo $file)
    {
        if (!$file->isReadable()) {
            throw new FileNotReadableException($file);
        }
    }

    /**
     * @param \SplFileInfo $file
     *
     * @throws FileNotWritableException
     */
    private function ensureFileIsWritable(\SplFileInfo $file)
    {
        if (!$file->isWritable()) {
            throw new FileNotWritableException($file);
        }
    }

    private function ensureUsernameDoesNotExist(string $username)
    {
        if (!is_null($this->findByUsername($username))) {
            throw new ValidationException("Username already exists");
        }
    }

    private function read() : UserCollection
    {
        $fileContent = file_get_contents($this->file->getPathname());
        if ($fileContent === '') {
            return new UserCollection();
        }

        return unserialize($fileContent);
    }

    private function write(UserCollection $users)
    {
        file_put_contents($this->file->getPathname(), serialize($users));
    }

    public function create(string $username, string $password, string $firstName, string $lastName, string $email) : User
    {
        $this->ensureUsernameDoesNotExist($username);
        $id = random_bytes(7);
        $user = new User($id, $username, $password, $firstName, $lastName, $email);
        $this->write($this->read()->add($user));
        return $user;
    }

    public function update(User $user) : User
    {
        $id = $user->getId();
        $result = $this->read()->filter(function (User $user) use ($id) {
            return strcmp($user->getId(), $id) === 0;
        });
        if ($result->count() == 0) {
            return null;
        }
        array_values($result->toArray())[0] = $user;
        return $user;
    }

    public function findByUsername(string $username)
    {
        $result = $this->read()->filter(function (User $user) use ($username) {
            return strcmp($user->getUsername(), $username) === 0;
        });
        if ($result->count() == 0) {
            return null;
        }
        return array_values($result->toArray())[0];
    }

    public function findById(string $id) : User
    {
        $result = $this->read()->filter(function (User $user) use ($id) {
            return strcmp($user->getId(), $id) === 0;
        });
        if ($result->count() == 0) {
            return null;
        }
        return array_values($result->toArray())[0];
    }

    public function getAll() : UserCollection
    {
        return $this->read();
    }
}