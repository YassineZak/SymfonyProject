<?php
namespace OC\PlatformBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use OC\PlatformBundle\Entity\Category;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use OC\PlatformBundle\Entity\Skil;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use OC\PlatformBundle\Entity\Image;
use Sonata\AdminBundle\Form\Type\AdminType;
use Application\Sonata\UserBundle\Entity\User;


class AdvertAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('title', 'text')
        ->add('date', 'datetime')
        ->add('user', EntityType::class, array(
          'class'        => 'Application\Sonata\UserBundle\Entity\User',
          'choice_label' => 'username',
          'disabled' => true))
        ->add('email',    'email')
        ->add('content',  'textarea')
        ->add('image', AdminType::class)
        ->add('categories', EntityType::class, array(
          'class'        => 'OCPlatformBundle:Category',
          'choice_label' => 'name',
          'multiple'     => true,))
        ->add('skill', EntityType::class, array(
          'class'        => 'OCPlatformBundle:Skill',
          'choice_label' => 'name',
          'multiple'     => true,
          'expanded'     => true,))
          ->add('nbApplications', 'hidden')
        ->add('published', 'checkbox', array('required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('title')
        ->add('date')
        ->add('user')
        ->add('email')
        ->add('content')
        ->add('skill')
        ->add('image')
        ->add('categories')
        ->add('nbApplications')
        ->add('published');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
        $listMapper->addIdentifier('date');
        $listMapper->addIdentifier('user');
        $listMapper->addIdentifier('email');
        $listMapper->addIdentifier('content');
        $listMapper->addIdentifier('image');
        $listMapper->addIdentifier('skill');
        $listMapper->addIdentifier('categories');
        $listMapper->addIdentifier('nbApplications');
        $listMapper->addIdentifier('published');
    }
}
?>
