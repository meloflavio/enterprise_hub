<?php

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\UserBundle\Form\Type\RolesMatrixType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserAdmin extends BaseUserAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('general', ['class' => 'col-md-4'])
            ->add('username', null, ['attr' => [
            ],])
            ->add('email', null, ['attr' => [
            ],])
           ->add('plainPassword', PasswordType::class, [
                    'required' => (!$this->hasSubject() || null === $this->getSubject()->getId()),
                ])
            ->add('enabled', null)
            ->end()
            ->with('roles', ['class' => 'col-md-8'])
            ->add('realRoles', RolesMatrixType::class, [
                'label' => false,
                'multiple' => true,
                'required' => false,
                'excluded_roles' => ['ROLE_SONATA_ADMIN', 'ROLE_ALLOWED_TO_SWITCH'],
            ])
            ->end()
           ;
    }

}
