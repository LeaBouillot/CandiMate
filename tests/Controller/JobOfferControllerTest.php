<?php
namespace App\Tests\Controller;

use App\Entity\JobOffer;
use App\Entity\User;
use App\Enum\JobStatus;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;

class JobOfferControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    private $user;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();

        // Nettoyer et recréer la base de données
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        // Créer un utilisateur pour tous les tests
        $this->user = new User();
        $this->user->setEmail('test'.uniqid().'@example.com')
            ->setPassword('password')
            ->setFirstName('Test')
            ->setLastName('User');
        
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }

    public function testCreateJobOffer(): void
    {
        $this->client->loginUser($this->user);

        $crawler = $this->client->request('GET', '/job-offers/new');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Enregistrer')->form([
            'job_offer[title]' => 'Développeur PHP',
            'job_offer[company]' => 'Test Company',
            'job_offer[location]' => 'Paris',
            'job_offer[status]' => JobStatus::A_POSTULER->value,
        ]);

        $this->client->submit($form);
        $this->assertResponseRedirects('/job-offers');
    }

    public function testListJobOffers(): void
    {
        $this->client->loginUser($this->user);

        // Créer quelques offres
        $jobOffer1 = new JobOffer();
        $jobOffer1->setTitle('Job 1')
            ->setCompany('Company 1')
            ->setAppUser($this->user)
            ->setStatus(JobStatus::A_POSTULER);

        $jobOffer2 = new JobOffer();
        $jobOffer2->setTitle('Job 2')
            ->setCompany('Company 2')
            ->setAppUser($this->user)
            ->setStatus(JobStatus::ENTRETIEN);

        $this->entityManager->persist($jobOffer1);
        $this->entityManager->persist($jobOffer2);
        $this->entityManager->flush();

        // Tester la liste
        $crawler = $this->client->request('GET', '/job-offers');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Job 1');
        $this->assertSelectorTextContains('body', 'Job 2');
    }

    public function testShowJobOffer(): void
    {
        $this->client->loginUser($this->user);

        // Créer une offre
        $jobOffer = new JobOffer();
        $jobOffer->setTitle('Test Job')
            ->setCompany('Test Company')
            ->setAppUser($this->user)
            ->setStatus(JobStatus::A_POSTULER);

        $this->entityManager->persist($jobOffer);
        $this->entityManager->flush();

        // Tester la vue détaillée
        $crawler = $this->client->request('GET', '/job-offers/'.$jobOffer->getId());
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Test Job');
        $this->assertSelectorTextContains('body', 'Test Company');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}