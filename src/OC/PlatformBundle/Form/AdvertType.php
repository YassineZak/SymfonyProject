<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
    ->add('date',      DateTimeType::class,
    [ 'widget' => 'single_text',
      'attr' => ['class' => 'datepicker'],
      'format' =>'dd/MM/yyyy',
      'html5' => false,])
    ->add('title',     TextType::class)
    ->add('email',    EmailType::class)
    ->add('content',  CKEditorType::class)
    ->add('image',     ImageType::class)
    ->add('categories', EntityType::class, array(
      'class'        => 'OCPlatformBundle:Category',
      'choice_label' => 'name',
      'multiple'     => true,))
      ->add('skill', EntityType::class, array(
        'class'        => 'OCPlatformBundle:Skill',
        'choice_label' => 'name',
        'multiple'     => true,
        'expanded'     => true,))
    ->add('published', CheckboxType::class, array('required' => false))
    ->add('save',      SubmitType::class);
    // On ajoute une fonction qui va écouter un évènement
$builder->addEventListener(
  FormEvents::PRE_SET_DATA,    // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
  function(FormEvent $event) { // 2e argument : La fonction à exécuter lorsque l'évènement est déclenché
    // On récupère notre objet Advert sous-jacent
    $advert = $event->getData();

    // Cette condition est importante, on en reparle plus loin
    if (null === $advert) {
      return; // On sort de la fonction sans rien faire lorsque $advert vaut null
    }
  }
);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_platformbundle_advert';
    }


}
