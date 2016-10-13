<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

use Mihaeu\Hotshowers\Exceptions\FileNotReadableException;
use Mihaeu\Hotshowers\Exceptions\FileNotWritableException;

class UserFileMapper implements UserMapper
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

    public function save(User $user)
    {
        $this->write($this->read()->add($user));
    }

    public function findAll() : UserCollection
    {
        return $this->read();
    }

    public function findByName(string $query) : UserCollection
    {
        return $this->read()->filter(function (User $user) use ($query) {
            return strpos((string) $user->name()->firstName(), $query) !== false
                || strpos((string) $user->name()->lastName(), $query) !== false;
        });
    }

    public function findByEmail(string $query) : UserCollection
    {
        return $this->read()->filter(function (User $user) use ($query) {
            return strpos((string) $user->email(), $query) !== false;
        });
    }

    public function findByUsername(string $query) : UserCollection
    {
        return $this->read()->filter(function (User $user) use ($query) {
            return strpos((string) $user->username(), $query) !== false;
        });
    }

    public function findByCity(string $query) : UserCollection
    {
        return $this->read()->filter(function (User $user) use ($query) {
            return strpos((string) $user->address()->city(), $query) !== false;
        });
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
}
