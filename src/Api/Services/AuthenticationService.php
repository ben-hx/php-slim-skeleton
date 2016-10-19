<?php
declare (strict_types = 1);

namespace BenHx\Api\Services;

use BenHx\Api\Models\User\User;
use BenHx\Api\Models\User\UserRepository;
use Slim\Middleware\HttpBasicAuthentication\AuthenticatorInterface;
use Firebase\JWT\JWT;
use Slim\Middleware\JwtAuthentication;
use Tuupola\Base62;


class AuthenticationService implements AuthenticatorInterface
{
    private $userRepository;
    private $currentUser;
    private $jwtAuthentication;

    /**
     * AuthenticationService constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository, JwtAuthentication $jwtAuthentication)
    {
        $this->userRepository = $userRepository;
        $this->currentUser = null;
        $this->userNameFromToken = "";
        $this->jwtAuthentication = $jwtAuthentication;
    }

    public function __invoke(array $arguments) {
        return $this->authenticateByUserNameAndPassword($arguments['user'], $arguments['password']);
    }

    public function register(string $username, string $password, string $firstName = "", string $lastName = "", string $email = "") {
        $result = $this->userRepository->create($username, $password, $firstName, $lastName, $email);
        if ($result !== null) {
            $this->currentUser = $result;
        }
        return $result;
    }

    private function isTokenAuthenticated() {
        return $this->userNameFromToken !== '';
    }

    private function authenticateByUserNameAndPassword(string $username, string $password) {
        $user = $this->userRepository->findByUsername($username);
        if ($user !== null && $user->verifyPassword($password)) {
            $this->currentUser = $user;
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getUserNameFromToken(): string
    {
        return $this->userNameFromToken;
    }

    /**
     * @param string $userNameFromToken
     */
    public function setUserNameFromToken(string $userNameFromToken)
    {
        $this->userNameFromToken = $userNameFromToken;
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        if ($this->isTokenAuthenticated()) {
            $this->currentUser = $this->userRepository->findByUsername($this->userNameFromToken);
        }
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
        $secret = $this->jwtAuthentication->getSecret();
        $algorithm = $this->jwtAuthentication->getAlgorithm();
        return JWT::encode($payload, $secret, $algorithm);
    }

}