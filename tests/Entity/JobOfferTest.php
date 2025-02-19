<?php
namespace App\Tests\Entity;

use App\Entity\JobOffer;
use App\Entity\User;
use App\Enum\JobStatus;
use PHPUnit\Framework\TestCase;

class JobOfferTest extends TestCase
{
    private JobOffer $jobOffer;

    protected function setUp(): void
    {
        $this->jobOffer = new JobOffer();
    }

    public function testInitialState(): void
    {
        $this->assertNull($this->jobOffer->getId());
        $this->assertNull($this->jobOffer->getTitle());
        $this->assertNull($this->jobOffer->getCompany());
        $this->assertEquals(JobStatus::A_POSTULER, $this->jobOffer->getStatus());
        $this->assertEmpty($this->jobOffer->getLinkedInMessages());
        $this->assertEmpty($this->jobOffer->getCoverLetters());
    }

    public function testLifecycleCallbacks(): void
    {
        $this->jobOffer->setCreatedAtValue();
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->jobOffer->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->jobOffer->getUpdatedAt());
    }

    public function testUserAssociation(): void
    {
        $user = new User();
        $this->jobOffer->setAppUser($user);
        $this->assertSame($user, $this->jobOffer->getAppUser());
    }
}
