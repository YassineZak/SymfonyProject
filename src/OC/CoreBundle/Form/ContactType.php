<?php

namespace OC\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, array('attr' => array('placeholder' => 'Votre nom'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez saisir votre nom")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Votre adresse email'),
                    'constraints' => array(
                        new NotBlank(array("message" => "Veuillez saisir votre adresse email")),
                        new Email(array("message" => "Votre adresse mail ne semble pas correct")),
                    )
                ))
                ->add('subject', TextType::class, array('attr' => array('placeholder' => 'Sujet'),
                        'constraints' => array(
                            new NotBlank(array("message" => "Veuillez saisir un sujet")),
                        )
                    ))
                    ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Votre message'),
                            'constraints' => array(
                                new NotBlank(array("message" => "Veuillez saisir votre message")),
                            )
                        ))
        ->add('envoyer',      SubmitType::class);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\CoreBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_corebundle_contact';
    }


}
