<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;

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
    ->remove('published');
  }

  public function getParent()
  {
    return AdvertType::class;
  }
}
