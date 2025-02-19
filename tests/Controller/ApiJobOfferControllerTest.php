<?php
namespace App\Tests\Controller;

use App\Entity\JobOffer;
use App\Entity\User;
use App\Enum\JobStatus;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiJobOfferControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testUpdateStatus(): void
    {
        // Créer les données de test
        $user = new User();
        $user->setEmail('api@test.com')
            ->setPassword('password')
            ->setFirstName('API')
            ->setLastName('Test');
        
        $jobOffer = new JobOffer();
        $jobOffer->setTitle('Test Job')
            ->setCompany('Test Company')
            ->setAppUser($user)
            ->setStatus(JobStatus::A_POSTULER);
        
        $this->entityManager->persist($user);
        $this->entityManager->persist($jobOffer);
        $this->entityManager->flush();
        
        $this->client->loginUser($user);

        // Test de mise à jour du statut
        $this->client->request(
            'POST',
            '/api/job-offers/update-status',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'jobOfferId' => $jobOffer->getId(),
                'status' => JobStatus::ENTRETIEN->value
            ])
        );

        $this->assertResponseIsSuccessful();
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertTrue($response['success']);
    }
}