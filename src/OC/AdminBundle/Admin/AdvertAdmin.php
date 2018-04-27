<?php
namespace OC\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use OC\PlatformBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AdvertAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', TextType::class);
        $formMapper->add('author', TextType::class);
        $formMapper->add('email', EmailType::class);
        $formMapper->add('content', TextareaType::class);
        $formMapper->add('date', DateTimeType::class);
        $formMapper->add('categories', EntityType::class, array(
          'class'        => 'OCPlatformBundle:Category',
          'choice_label' => 'name',
          'multiple'     => true,));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
        $datagridMapper->add('author');
        $datagridMapper->add('email');
        $datagridMapper->add('content');
        $datagridMapper->add('date');
        $datagridMapper->add('categories');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
        $listMapper->addIdentifier('author');
        $listMapper->addIdentifier('email');
        $listMapper->addIdentifier('date');
        $listMapper->addIdentifier('categories');
        $listMapper->addIdentifier('content');
    }
}


 ?>
