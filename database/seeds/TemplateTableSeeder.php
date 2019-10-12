<?php

use Illuminate\Database\Seeder;
use App\Models\MedicalTemplate;

class TemplateTableSeeder extends Seeder
{
    /*type: A - Answer; Q - Question*/
    public function run()
    {
        $query = [
            'name' => 'Szablon 1',
            'type' => 'A',
        ];
        $update = [
            'name' => 'Szablon 1',
            'type' => 'A', 
            'desc' => 'Opis szablonu numer 1 A',
        ];
        $result = MedicalTemplate::updateOrCreate($query,$update);
        
        $query = [
            'name' => 'Szablon 1',
            'type' => 'Q',
        ];
        $update = [
            'name' => 'Szablon 1',
            'type' => 'Q', 
            'desc' => 'Opis szablonu numer 1 Q',
        ];
        $result = MedicalTemplate::updateOrCreate($query,$update);

        $query = [
            'name' => 'Szablon 2',
            'type' => 'A',
        ];
        $update = [
            'name' => 'Szablon 2',
            'type' => 'A', 
            'desc' => 'Opis szablonu numer 2 A',
        ];
        $result = MedicalTemplate::updateOrCreate($query,$update);
        
        $query = [
            'name' => 'Szablon 2',
            'type' => 'Q',
        ];
        $update = [
            'name' => 'Szablon 2',
            'type' => 'Q', 
            'desc' => 'Opis szablonu numer 2 Q',
        ];
        $result = MedicalTemplate::updateOrCreate($query,$update);
        
    }
}
