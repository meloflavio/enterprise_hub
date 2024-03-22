<?php

namespace App\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Sonata\AdminBundle\Admin\AbstractAdmin as AbstractAdminRoot;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AbstractAdmin
 * @package App\Admin
 */
abstract class AbstractAdmin extends AbstractAdminRoot
{

    /**
     * @var string
     */
    protected string $translationDomain = 'App';


    public function __construct(
        protected EntityManagerInterface        $entityManager,
        protected RequestStack                  $requestStack,
        protected TokenStorageInterface         $tokenStorage,
        protected AuthorizationCheckerInterface $authorizationChecker,
    )
    {

        parent::__construct();
    }

    public function checkUserHasRole(string $role): bool
    {

        try {
            return $this->authorizationChecker->isGranted($role);
        } catch (AuthenticationCredentialsNotFoundException $e) {
            return false;
        }
    }

    /**
     * @param $class
     * @param $id
     *
     * @return mixed
     * @throws ORMException
     */
    protected function getReference($class, $id): mixed
    {
        return $this->entityManager->getReference($class, $id);

    }


    /**
     * @param $class
     *
     * @return mixed
     */
    protected function getDefaultRepository($class): EntityRepository
    {
        return $this->entityManager->getRepository($class);

    }

    /**
     * @return UserInterface
     */
    protected function getUser(): UserInterface
    {
        return $this->tokenStorage->getToken()->getUser();
    }

}
