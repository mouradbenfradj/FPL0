<?php

namespace ArticleBundle\Admin;


use ArticleBundle\Entity\Article;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('titre')->add('description')->add('categorie', ChoiceType::class, array(
            'choices' => Article::$choiceCategorie,
            'multiple' => false
        ))->add('paragraphs', CollectionType::class, array(
            'by_reference' => false
        ),
            array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position'
            ))
            ->add('imageFile', 'file', array('required' => false));
    }

    public function prePersist($object)
    {

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUtilisateur($user);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('titre')->add('description')->add('categorie');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')->add('titre')->add('categorie')->add('imageFile', null, array('template' => 'admin/image.html.twig'));
    }

}