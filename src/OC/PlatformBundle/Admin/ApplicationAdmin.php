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


class ApplicationAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('author', 'text')
        ->add('content', 'text')
        ->add('date', 'date');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('author')
        ->add('content')
        ->add('date');

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('author');
        $listMapper->addIdentifier('content');
        $listMapper->addIdentifier('date');
    }
}
?>
