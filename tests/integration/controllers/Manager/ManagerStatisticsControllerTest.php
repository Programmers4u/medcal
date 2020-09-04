<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManagerStatisticsControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateBusiness;

    protected $business;
    protected $owner;
    /**
     * @test
     */
    public function it_displays_the_business_listing()
    {
        $this->owner = $this->createUser();

        $businessOne = $this->createBusiness();
        $businessTwo = $this->createBusiness();

        $businessOne->owners()->save($this->owner);
        $businessTwo->owners()->save($this->owner);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.index'));

        $this->seePageIs('/user/businesses');
        $this->see('From here you can manage all your businesses');
        $this->see($businessOne->name);
        $this->see($businessTwo->name);
    }

}
