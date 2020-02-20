<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Business;
use Timegridio\Tests\Models\User;

/**
 * @covers Timegridio\Concierge\Models\Domain
 */
class DomainTest extends TestCaseDB
{
    use DatabaseTransactions;
    use CreateBusiness, CreateDomain, CreateUser;

    /** @test */
    public function it_belongs_to_an_owner_user()
    {
        $domain = $this->createDomain();

        $this->assertInstanceOf(User::class, $domain->owner);
    }

    /** @test */
    public function it_holds_multiple_businesses_through_the_owner_user()
    {
        $owner = $this->createUser();

        $businessOne = $this->createBusiness();
        $businessTwo = $this->createBusiness();
        $businessThree = $this->createBusiness();

        $businessOne->owners()->save($owner);
        $businessTwo->owners()->save($owner);
        $businessThree->owners()->save($owner);

        $domain = $this->createDomain();

        foreach ($domain->businesses as $business) {
            $this->assertInstanceOf(Business::class, $business);
        }
    }
}
