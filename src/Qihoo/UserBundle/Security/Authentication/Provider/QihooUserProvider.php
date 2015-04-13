<?php
namespace Qihoo\UserBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Qihoo\UserBundle\Security\Authentication\Token\QihooUserToken;

class QihooUserProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function authenticate(TokenInterface $token)
    {
        $uname = $token->getUname();
        $user = $this->userProvider->loadUserByUsername($uname);
        if ($user) {
            $authToken = new QihooUserToken($user->getRoles());
            $authToken->setDisplayName($token->getDisplayName());
            $authToken->setUname($token->getUname());
            $authToken->setEmail($token->getEmail());
            $authToken->setUser($user);
            $authToken->setAuthenticated(true);
            return $authToken;
        } else {
            throw new UsernameNotFoundException("username($uname) not in db!"); 
        }
    }
    
    public function supports(TokenInterface $token)
    {
        return $token instanceof QihooUserToken;
    }
}
