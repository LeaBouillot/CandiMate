<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('title')
                ->setHelp('Enter the job title')
                ->setLabel('Title'),
            TextField::new('company')
                ->setHelp('Enter company name')
                ->setLabel('Company'),
            TextField::new('location')
                ->setHelp('Enter job location')
                ->setLabel('Location'),
            TextField::new('salary')
                ->setHelp('Enter the salary')
                ->setLabel('Salary'),
            DateField::new('applicationDate')
                ->setLabel('Application Date'),
            AssociationField::new('app_user')
                ->setLabel('User'),
        ];
    }
}