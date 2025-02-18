<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use App\Enum\JobStatus;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->displayIf(static function ($entity) {
                    return !$entity->getCoverLetters()->count() && !$entity->getLinkedInMessages()->count();
                });
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('title')->setLabel('Title'),
            TextField::new('company')->setLabel('Company'),
            TextField::new('location')->setLabel('Location'),
            TextField::new('salary')->setLabel('Salary'),
            TextField::new('contactPerson')->setLabel('Contact Person'),
            TextField::new('contactEmail')->setLabel('Contact Email'),
            DateField::new('applicationDate')->setLabel('Application Date'),
            ChoiceField::new('status')
                ->setChoices([
                    'À postuler' => JobStatus::A_POSTULER->value,
                    'En attente' => JobStatus::EN_ATTENTE->value,
                    'Entretien' => JobStatus::ENTRETIEN->value,
                    'Refusé' => JobStatus::REFUSE->value,
                    'Accepté' => JobStatus::ACCEPTE->value,
                ]),
            AssociationField::new('app_user')
                ->setLabel('User')
                ->setFormTypeOption('choice_label', 'email')
                ->formatValue(function ($value, $entity) {
                    return $entity->getAppUser() ? $entity->getAppUser()->getEmail() : '';
                }),
        ];
    }

    public function delete(AdminContext $context)
    {
        /** @var JobOffer $jobOffer */
        $jobOffer = $context->getEntity()->getInstance();

        if ($jobOffer->getCoverLetters()->count() > 0 || $jobOffer->getLinkedInMessages()->count() > 0) {
            $this->addFlash('error', 'Cannot delete job offer with associated cover letters or LinkedIn messages');
            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(self::class)->setAction(Action::INDEX)->generateUrl());
        }

        $entityManager = $this->container->get(EntityManagerInterface::class);
        $entityManager->remove($jobOffer);
        $entityManager->flush();

        $this->addFlash('success', 'Job offer has been deleted');

        return $this->redirect($context->getReferrer());
    }
}