<?php
declare (strict_types = 1);

namespace BenHx\Api\Services;

use BenHx\Api\Models\User\User;
use BenHx\Api\Models\User\UserRepository;
use Slim\Middleware\HttpBasicAuthentication\AuthenticatorInterface;
use Firebase\JWT\JWT;

use Tuupola\Base62;


class AuthenticationService implements AuthenticatorInterface
{
    private $userRepository;
    private $currentUser;
    private $config;

    /**
     * AuthenticationService constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository, array $config)
    {
        $this->userRepository = $userRepository;
        $this->currentUser = null;
        $this->config = $config;
    }

    public function __invoke(array $arguments) {
        return $this->authenticate($arguments['user'], $arguments['password']);
    }

    public function register(string $username, string $password, string $firstName = "", string $lastName = "", string $email = ""): User {
        $result = $this->userRepository->create($username, $password, $firstName, $lastName, $email);
        if ($result !== null) {
            $this->currentUser = $result;
        }
        return $result;
    }

    private function authenticate(string $username, string $password) {
        $user = $this->userRepository->findByUsername($username);
        if ($user !== null && $user->verifyPassword($password)) {
            $this->currentUser = $user;
            return true;
        }
        return false;
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    public function getToken(): string
    {
        $now = new \DateTime();
        $future = new \DateTime("now +2 hours");
        $jti = Base62::encode(random_bytes(16));
        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => $jti,
            "sub" => $this->currentUser->getUsername(),
        ];
        $secret = $this->config['application']['app_secret'];
        $algorithm = $this->config['application']['app_secret_algorithm'];
        return JWT::encode($payload, $secret, $algorithm);
    }
}