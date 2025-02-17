<?php

namespace App\Controller\Admin;

use App\Entity\CoverLetter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class CoverLetterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CoverLetter::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Lettre de motivation')
            ->setEntityLabelInPlural('Lettres de motivation')
            ->setSearchFields(['content'])
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setTimezone('Europe/Paris')
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('jobOffer')
            ->add('app_user')
            ->add('createdAt');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextEditorField::new('content', 'Contenu')
            ->setNumOfRows(20)
            ->setTrixEditorConfig([
                'blockAttributes' => true,
                'tableAttributes' => true,
            ]);
        yield AssociationField::new('jobOffer', 'Offre d\'emploi')
            ->setFormTypeOption('choice_label', 'title');
        yield AssociationField::new('app_user', 'Utilisateur')
            ->setFormTypeOption('choice_label', 'email');

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            yield DateTimeField::new('createdAt', 'Créé le');
            yield DateTimeField::new('updatedAt', 'Modifié le');
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter une lettre');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Modifier');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Supprimer');
            });
    }
}
