<?php

namespace App\Tests\Entity;

use App\Entity\CoverLetter;
use App\Entity\JobOffer;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CoverLetterTest extends TestCase
{
    private CoverLetter $coverLetter;

    protected function setUp(): void
    {
        $this->coverLetter = new CoverLetter();
    }

    public function testInitialState(): void
    {
        $this->assertNull($this->coverLetter->getId());
        $this->assertNull($this->coverLetter->getContent());
        $this->assertNull($this->coverLetter->getJobOffer());
        $this->assertNull($this->coverLetter->getAppUser());
    }

    public function testContentMutator(): void
    {
        $content = 'Test cover letter content';
        $this->coverLetter->setContent($content);
        $this->assertEquals($content, $this->coverLetter->getContent());
    }

    public function testAssociations(): void
    {
        $jobOffer = new JobOffer();
        $user = new User();
        
        $this->coverLetter->setJobOffer($jobOffer);
        $this->coverLetter->setAppUser($user);
        
        $this->assertSame($jobOffer, $this->coverLetter->getJobOffer());
        $this->assertSame($user, $this->coverLetter->getAppUser());
    }
}