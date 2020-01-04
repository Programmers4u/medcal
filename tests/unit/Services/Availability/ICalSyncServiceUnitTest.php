<?php

use App\TG\Availability\ICalSyncService;
use Illuminate\Support\Facades\Storage;

class ICalSyncServiceUnitTest extends TestCase
{
    use CreateBusiness, CreateHumanresource;

    protected $icalsync;

    protected $humanresource;

    public function setUp()
    {
        parent::setUp();

        $this->arrangeScenario();
    }

    /**
     * @test
     */
    public function it_retrieves_an_ical_remote_file()
    {
        $filepath = "business/{$this->humanresource->business->id}/ical/calendar-{$this->humanresource->slug}.ics";

        $this->assertFalse(Storage::exists($filepath));

        $icalsync = Mockery::mock(ICalSyncService::class)->makePartial();

        $icalsync->shouldReceive('getRemoteContents')->once()->andReturn($this->getStub());

        $icalsync->humanresource($this->humanresource)->sync();

        $this->assertTrue(Storage::exists($filepath));
    }

    protected function arrangeScenario()
    {
        $business = $this->createBusiness();
        $filepath = "storage/app/business/{$business->id}/ical/calendar-{$business->slug}.ics";

        $this->humanresource = $this->createHumanresource([
            'business_id'   => $business->id,
            'calendar_link' =>  url($filepath),
            ]);
    }

    protected function getStub()
    {
        return file_get_contents(__DIR__.'/../ICal/stubs/ical-stub.ics');
    }
}
