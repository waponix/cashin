<?php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class AbstractBaseService
{
    public function __construct(
        protected RequestStack $requestStack,
        protected EntityManagerInterface $em,
        private FormFactoryInterface $formFactory,
        private TokenStorageInterface $tokenStorage,
    )
    {
        
    }

    protected function getUser(): ?User
    {
        return $this->em->getRepository(User::class)->findAll()[0];
        return $this->tokenStorage->getToken()?->getUser();
    }

    protected function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    protected function createApiForm(string $type, $data = null, array $options = []): FormInterface
    {
        $options = array_merge([
            'csrf_protection' => false,
        ], $options);

        return $this->formFactory->create($type, $data, $options);
    }
}