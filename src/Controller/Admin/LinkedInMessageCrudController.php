<?php

namespace App\Controller\Admin;

use App\Entity\LinkedInMessage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class LinkedInMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LinkedInMessage::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextEditorField::new('content')
                ->setHelp('Enter the LinkedIn message content')
                ->setLabel('Content'),
            AssociationField::new('jobOffer')
                ->setLabel('Job Offer'),
            AssociationField::new('app_user')
                ->setLabel('User'),
            DateTimeField::new('createdAt')
                ->onlyOnDetail(),
        ];
    }
}