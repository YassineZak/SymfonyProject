<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdvertSearchType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->remove('date')
    ->remove('image')
    ->remove('email')
    ->remove('content')
    ->remove('categories')
    ->remove('skill')
    ->remove('number')
    ->remove('published')
    ->remove('save')
    ->add('rechercher',      SubmitType::class );
  }

  public function getParent()
  {
    return AdvertType::class;
  }
}
