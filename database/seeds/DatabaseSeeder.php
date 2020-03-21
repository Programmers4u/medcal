<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('NotifynderCategoriesSeeder');
        $this->command->info('Seeded the Notifynder Categories!');

        //$this->call('CategoriesSeeder');
        //$this->command->info('Seeded the Param Categories!');

        //$this->call('CountriesSeeder');
        //$this->command->info('Seeded the Param Countries!');

        //$this->call('RolesTableSeeder');
        //$this->command->info('Seeded the Param Roles!');

        //$this->call('ContactTableSeeder');
        //$this->command->info('Seeded the Param Contact from csv file!');

        //$this->call('MedicinesTableSeeder');
        //$this->command->info('Seeded the Medicines from csv file!');
        
        //$this->call('TemplateTableSeeder');
        //$this->command->info('Seeded the Temple');
        
    }
}
