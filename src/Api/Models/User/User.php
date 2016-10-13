<?php

declare (strict_types = 1);

namespace BenHx\Api\Models\User;
use BenHx\Api\Exceptions\ValidationException;

/**
 * @SWG\Definition(@SWG\Xml(name="User"))
 */
class User
{
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $id;

    /**
     * @SWG\Property()
     * @var string
     */
    private $username;

    /**
     * @var string
     * @SWG\Property()
     */
    private $password;

    /**
     * @SWG\Property
     * @var string
     */
    private $firstName;

    /**
     * @SWG\Property()
     * @var string
     */
    private $lastName;

    /**
     * @var string
     * @SWG\Property()
     */
    private $email;

    /**
     * @var string
     * @SWG\Property()
     */
    private $phone;

    /**
     * User constructor.
     * @param int $id
     * @param string $username
     * @param $password
     * @param string $firstName
     * @param $lastName
     * @param string $email
     */
    public function __construct(string $id, string $username, string $password, string $firstName, string $lastName, string $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $this->hashPassword($password);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        if (!$this->verifyEMail($email)) {
            throw new ValidationException('Invalid Email Adress');
        }
        $this->email = $email;
    }

    /**
     * @return string
     */
    private function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return bool
     */
    private function verifyEMail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function verifyPassword(string $otherPassword): bool
    {
        return password_verify($otherPassword, $this->password);
    }

}