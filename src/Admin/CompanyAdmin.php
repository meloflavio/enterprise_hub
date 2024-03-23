<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\State;
use App\Entity\City;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

final class CompanyAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('name')
            ->add('address')
            ->add('email')
            ->add('phone')
            ->add('cnpj');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('name')
            ->add('cnpj')
            ->add('email')
            ->add('phone')
            ->add('address')
            ->add('city.full')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    public function orderCities($cities)
    {
        $citiesArray = $cities;

        usort($citiesArray, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        return $citiesArray;
    }

    protected function configureFormFields(FormMapper $form): void
    {;
        $form
            ->add('name')
            ->add('cnpj', null, [
                'attr' => ['class' => 'cnpj'],
            ])
            ->add('email')
            ->add('phone', null, [
                'attr' => ['class' => 'telefone'],
            ])
            ->add('address')
            ->add('state', EntityType::class, [
                'class' => State::class,
                'required' => false,
                'placeholder' => 'place_state',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'data' =>  $this->getSubject()?->getCity()?->getState(),
            ])
            ->add('city');

        $formCityModifier = function (FormInterface $form, State $state = null) {
            $form->add('city', EntityType::class, [
                'class' => City::class,
                'choices' => $this->orderCities($state->getCities()->toArray()),
            ]);

        };


        $form->getFormBuilder()->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();

            $data = $event->getData();

            $state = $data ? $data->getState() : null;

            if ($state) {
                $form->add('city', EntityType::class, [
                    'class' => City::class,
                    'choices' => $this->orderCities($state->getCities()->toArray()),
                ]);
            }


        });

        $form->getFormBuilder()->get('state')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formCityModifier) {
                $state = $event->getForm()->getData();
                if ($state)
                    $formCityModifier($event->getForm()->getParent(), $state);
            }
        );
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('name')
            ->add('cnpj')
            ->add('email')
            ->add('phone')
            ->add('address')
            ->add('city.full');
    }
}
