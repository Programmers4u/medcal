<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Presenters\BusinessPresenter;
use Timegridio\Tests\Models\User;

class BusinessTest extends TestCaseDB
{
    use DatabaseTransactions;
    use CreateUser, CreateBusiness, CreateContact;

    /**
     * @test
     */
    public function a_business_automatically_sets_a_slug_on_create()
    {
        $business = $this->createBusiness(['name' => 'My Awesome Biz']);

        $this->assertEquals('my-awesome-biz', $business->slug);
    }

    /**
     * @covers \Timegridio\Concierge\Models\Business::__construct
     * @test
     */
    public function it_creates_a_business()
    {
        $business = $this->createBusiness();

        $this->assertInstanceOf(Business::class, $business);
    }

    /**
     * @covers \Timegridio\Concierge\Models\Business::__construct
     * @covers \Timegridio\Concierge\Models\Business::save
     * @test
     */
    public function it_creates_a_business_that_appears_in_db()
    {
        $business = $this->createBusiness();

        $this->seeInDatabase('businesses', ['slug' => $business->slug]);
    }

    /**
     * @covers \Timegridio\Concierge\Models\Business::__construct
     * @covers \Timegridio\Concierge\Models\Business::setSlugAttribute
     * @covers \Timegridio\Concierge\Models\Business::save
     * @test@
     */
    public function it_generates_slug_from_name()
    {
        $business = $this->createBusiness();

        $slug = str_slug($business->name);

        $this->assertEquals($slug, $business->slug);
    }

    /**
     * @covers \Timegridio\Concierge\Models\Business::getPresenterClass
     * @test
     */
    public function it_gets_business_presenter()
    {
        $business = $this->createBusiness();

        $businessPresenter = $business->getPresenterClass();

        $this->assertSame(BusinessPresenter::class, $businessPresenter);
    }

    /**
     * @covers \Timegridio\Concierge\Models\Business::setPhoneAttribute
     * @test
     */
    public function it_sets_empty_phone_attribute()
    {
        $business = $this->createBusiness(['phone' => '']);

        $this->assertNull($business->phone);
    }

    /**
     * @covers \Timegridio\Concierge\Models\Business::setPostalAddressAttribute
     * @test
     */
    public function it_sets_empty_postal_address_attribute()
    {
        $business = $this->createBusiness(['postal_address' => '']);

        $this->assertNull($business->postal_address);
    }

    /**
     * @covers \Timegridio\Concierge\Models\Business::owner
     * @test
     */
    public function it_gets_the_business_owner()
    {
        $owner = $this->createUser();

        $business = $this->createBusiness();
        $business->owners()->save($owner);

        $this->assertInstanceOf(User::class, $business->owner());
        $this->assertEquals($owner->name, $business->owner()->name);
    }

    /**
     * @covers \Timegridio\Concierge\Models\Business::owners
     * @test
     */
    public function it_gets_the_business_owners()
    {
        $owner1 = $this->createUser();
        $owner2 = $this->createUser();

        $business = $this->createBusiness();

        $business->owners()->save($owner1);
        $business->owners()->save($owner2);

        $this->assertInstanceOf(Collection::class, $business->owners);
        $this->assertCount(2, $business->owners);
    }

    /**
     * @test
     */
    public function it_has_humanresources()
    {
        $business = $this->createBusiness();

        $this->assertInstanceOf(HasMany::class, $business->humanresources());
    }

    /**
     * @test
     */
    public function it_has_bookings()
    {
        $business = $this->createBusiness();

        $this->assertInstanceOf(HasMany::class, $business->bookings());
    }

    /**
     * @test
     */
    public function it_has_service_types()
    {
        $business = $this->createBusiness();

        $this->assertInstanceOf(HasMany::class, $business->serviceTypes());
    }

    /**
     * @test
     */
    public function it_has_a_category()
    {
        $business = $this->createBusiness();

        $this->assertInstanceOf(BelongsTo::class, $business->category());
    }
}
