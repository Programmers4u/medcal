<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeedingUnitTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_demo_scenario()
    {
        $this->seed('TestingDatabaseSeeder');

        //$this->seeInDatabase('users', ['email' => 'demo@programmers4u.com']);
        //$this->seeInDatabase('users', ['email' => 'guest@programmers4u.com']);
    }
}
