<?php

use Illuminate\Database\Seeder;
use App\Models\MedicalTemplates;

class MedicalTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MedicalTemplates::updateOrCreate([
            'name' => 'Nieodwracalne zapalenie miazgi zęba',
            'type' => MedicalTemplates::TYPE_ANSWER, 
            'description' => 'Nieodwracalne zapalenie miazgi zęba'
        ]);         

        MedicalTemplates::updateOrCreate([
            'name' => 'Kamień nad i poddziąsłowy',
                'type' => MedicalTemplates::TYPE_ANSWER, 
                'description' => 'Kamień nad i poddziąsłowy'
        ]);         
        

        MedicalTemplates::updateOrCreate([
            'name' => 'Próchnica głęboka Klasa wg Blacka',
            'type' => MedicalTemplates::TYPE_ANSWER, 
            'description' => 'Próchnica głęboka Klasa wg Blacka'
        ]);         

        MedicalTemplates::updateOrCreate([
            'name' => 'Złamanie fragmentu korony zęba',
            'type' => MedicalTemplates::TYPE_ANSWER, 
            'description' => 'Złamanie fragmentu korony zęba'
        ]);         

        MedicalTemplates::updateOrCreate(
                ['name' => 'Ciąg dalszy leczenia endodontycznego zęba',
                    'type' => MedicalTemplates::TYPE_ANSWER, 
                    'description' => 'Ciąg dalszy leczenia endodontycznego zęba']
                );        
        
        MedicalTemplates::updateOrCreate(
                ['name' => 'Ubytek klinowy zęba klasa V wg Blacka',
                    'type' => MedicalTemplates::TYPE_ANSWER, 
                    'description' => 'Ubytek klinowy zęba klasa V wg Blacka']
                );      
        
        MedicalTemplates::updateOrCreate(
                ['name' => 'Stan po leczeniu endodontycznym',
                    'type' => MedicalTemplates::TYPE_ANSWER, 
                    'description' => 'Stan po leczeniu endodontycznym']
                );         

        MedicalTemplates::updateOrCreate(
                ['name' => 'Endodoncja 3 kanały I wizyta',
                    'type' => MedicalTemplates::TYPE_QUESTION, 
                    'description' => 'Ekstyrpacja w znieczuleniu nasiękowym Artykaina 4% z NOR Chemomechaniczne opracowanie 3 kanałów, płukanie NaOCl, kwasem cytrynowym, solą fizjologiczną  Tymczasowe wypełnienie kanałów Calcipast+Iodoform Coltosol F kotrola RTG']
                );         

        MedicalTemplates::updateOrCreate(
                // ['name' => 'Endodoncja 1 kanał'],
                ['name' => 'Endodoncja 1 kanał',
                    'type' => MedicalTemplates::TYPE_QUESTION, 
                    'description' => 'Ekstyrpacja w znieczuleniu 4% Artykaina z NOR Chemo-mechaniczne opracowanie kanału o długości 20 mmynowy Płukanie kanału NaOCl, kwasek cytrynowy, 0,9% NaCl Wypełnienie kanałów tymczasowe Calcipast+Iodoform Opatrunek Coltosol F']
                );         

        MedicalTemplates::updateOrCreate(
                // ['name' => 'Endodoncja 2 kanały'],
                ['name' => 'Endodoncja 2 kanały',
                    'type' => MedicalTemplates::TYPE_QUESTION, 
                    'description' => 'Ekstyrpacja w znieczuleniu 4% Artykaina z NOR Chemo-mechaniczne opracowanie 2 kanałów o długości dystalny 20 mm,mezjalny 20mm,  Płukanie kanału NaOCl, kwasek cytrynowy, 0,9% NaCl Wypełnienie kanałów tymczasowe Calcipast+Iodoform Opatrunek Coltosol F']
                );         

        MedicalTemplates::updateOrCreate(
                ['name' => 'Scaling i piaskowanie szczęki i żuchwy',
                    'type' => MedicalTemplates::TYPE_QUESTION, 
                    'description' => 'Scaling i piaskowanie szczęki i żuchwy. Mi Paste  .Zalecono płukanie jamy ustnej.Listerine Total Care ZERO']
                );         

        MedicalTemplates::updateOrCreate(
                // ['name' => 'Ekstrakcja zęba stałego'],
                ['name' => 'Ekstrakcja zęba stałego',
                    'type' => MedicalTemplates::TYPE_QUESTION, 
                    'description' => 'Ekstrakcja zęba stałego w znieczuleniu nasiękowym Artykaian 4% + NOR. Zębodół wyłyżeczkowano, założono SPONGOSTAN i 2 szwy.']
                );         

        MedicalTemplates::updateOrCreate(
                // ['name' => 'Odbudowa korony zęba na włóknie szklanym'],
                ['name' => 'Odbudowa korony zęba na włóknie szklanym',
                    'type' => MedicalTemplates::TYPE_QUESTION, 
                    'description' => 'Odbudowa korony zęba na włóknie szklanym Glassix +Build-It A3.']
                );         

        MedicalTemplates::updateOrCreate(
                // ['name' => 'Enodoncja 1 kanał WYPEŁNIENIE'],
                ['name' => 'Enodoncja 1 kanał WYPEŁNIENIE',
                    'type' => MedicalTemplates::TYPE_QUESTION, 
                    'description' => 'Chemo-mechaniczne opracowanie kanału o długości 20 mm Płukanie kanału NaOCl, kwasek cytrynowy, 0,9% NaCl. Ostateczne wypełnienie kanałów  Endomethasone + Gutaperka  Opatrunek Coltosol F. Kontrola RTG - kanał wypełniony prawidłowo.']
                );         

        MedicalTemplates::updateOrCreate(
                // ['name' => 'Endodoncja 2 kanały WYPEŁNIENIE'],
                ['name' => 'Endodoncja 2 kanały WYPEŁNIENIE',
                    'type' => MedicalTemplates::TYPE_QUESTION, 
                    'description' => 'Chemo-mechaniczne opracowanie kanałów o długości 20 mm  i 20 mm.Płukanie kanałów NaOCl, kwasek cytrynowy, 0,9% NaCl. Ostateczne wypełnienie kanałów  Endomethasone + Gutaperka  Opatrunek Coltosol F
Kontrola RTG - kanały wypełnione prawidłowo.']
                );         

        MedicalTemplates::updateOrCreate(
                // ['name' => 'Endodoncja 3 kanały WYPEŁNIENIE'],
                ['name' => 'Endodoncja 3 kanały WYPEŁNIENIE',
                    'type' => MedicalTemplates::TYPE_QUESTION, 
                    'description' => 'Chemo-mechaniczne opracowanie kanałów o długości 20 mm,20 mm  i 20 mm.Płukanie kanałów NaOCl, kwasek cytrynowy, 0,9% NaCl. Ostateczne wypełnienie kanałów  Endomethasone + Gutaperka  Opatrunek Coltosol F
Kontrola RTG - kanały wypełnione prawidłowo.']
                );         

        MedicalTemplates::updateOrCreate([
            'name' => 'Ekstrakcja zęba mlecznego',
            'type' => MedicalTemplates::TYPE_QUESTION, 
            'description' => 'Ekstrakcja zęba mlecznego'
        ]);         
    }
}
