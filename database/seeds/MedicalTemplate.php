<?php

use Illuminate\Database\Seeder;
use App\Models\MedicalTemplate;

class AddTemplateDocMed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MedicalTemplate::updateOrCreate(
                ['name' => 'Nieodwracalne zapalenie miazgi zęba'],
                ['name' => 'Nieodwracalne zapalenie miazgi zęba',
                    'type' => MedicalTemplate::$typeA, 
                    'desc' => 'Nieodwracalne zapalenie miazgi zęba']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Kamień nad i poddziąsłowy'],
                ['name' => 'Kamień nad i poddziąsłowy',
                    'type' => MedicalTemplate::$typeA, 
                    'desc' => 'Kamień nad i poddziąsłowy']
                );         
        

        MedicalTemplate::updateOrCreate(
                ['name' => 'Próchnica głęboka Klasa wg Blacka'],
                ['name' => 'Próchnica głęboka Klasa wg Blacka',
                    'type' => MedicalTemplate::$typeA, 
                    'desc' => 'Próchnica głęboka Klasa wg Blacka']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Złamanie fragmentu korony zęba'],
                ['name' => 'Złamanie fragmentu korony zęba',
                    'type' => MedicalTemplate::$typeA, 
                    'desc' => 'Złamanie fragmentu korony zęba']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Ciąg dalszy leczenia endodontycznego zęba'],
                ['name' => 'Ciąg dalszy leczenia endodontycznego zęba',
                    'type' => MedicalTemplate::$typeA, 
                    'desc' => 'Ciąg dalszy leczenia endodontycznego zęba']
                );        
        
        MedicalTemplate::updateOrCreate(
                ['name' => 'Ubytek klinowy zęba klasa V wg Blacka'],
                ['name' => 'Ubytek klinowy zęba klasa V wg Blacka',
                    'type' => MedicalTemplate::$typeA, 
                    'desc' => 'Ubytek klinowy zęba klasa V wg Blacka']
                );      
        
        MedicalTemplate::updateOrCreate(
                ['name' => 'Stan po leczeniu endodontycznym'],
                ['name' => 'Stan po leczeniu endodontycznym',
                    'type' => MedicalTemplate::$typeA, 
                    'desc' => 'Stan po leczeniu endodontycznym']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Endodoncja 3 kanały I wizyta'],
                ['name' => 'Endodoncja 3 kanały I wizyta',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Ekstyrpacja w znieczuleniu nasiękowym Artykaina 4% z NOR Chemomechaniczne opracowanie 3 kanałów, płukanie NaOCl, kwasem cytrynowym, solą fizjologiczną  Tymczasowe wypełnienie kanałów Calcipast+Iodoform Coltosol F kotrola RTG']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Endodoncja 1 kanał'],
                ['name' => 'Endodoncja 1 kanał',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Ekstyrpacja w znieczuleniu 4% Artykaina z NOR Chemo-mechaniczne opracowanie kanału o długości 20 mmynowy Płukanie kanału NaOCl, kwasek cytrynowy, 0,9% NaCl Wypełnienie kanałów tymczasowe Calcipast+Iodoform Opatrunek Coltosol F']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Endodoncja 2 kanały'],
                ['name' => 'Endodoncja 2 kanały',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Ekstyrpacja w znieczuleniu 4% Artykaina z NOR Chemo-mechaniczne opracowanie 2 kanałów o długości dystalny 20 mm,mezjalny 20mm,  Płukanie kanału NaOCl, kwasek cytrynowy, 0,9% NaCl Wypełnienie kanałów tymczasowe Calcipast+Iodoform Opatrunek Coltosol F']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Scaling i piaskowanie szczęki i żuchwy'],
                ['name' => 'Scaling i piaskowanie szczęki i żuchwy',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Scaling i piaskowanie szczęki i żuchwy. Mi Paste  .Zalecono płukanie jamy ustnej.Listerine Total Care ZERO']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Ekstrakcja zęba stałego'],
                ['name' => 'Ekstrakcja zęba stałego',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Ekstrakcja zęba stałego w znieczuleniu nasiękowym Artykaian 4% + NOR. Zębodół wyłyżeczkowano, założono SPONGOSTAN i 2 szwy.']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Odbudowa korony zęba na włóknie szklanym'],
                ['name' => 'Odbudowa korony zęba na włóknie szklanym',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Odbudowa korony zęba na włóknie szklanym Glassix +Build-It A3.']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Enodoncja 1 kanał WYPEŁNIENIE'],
                ['name' => 'Enodoncja 1 kanał WYPEŁNIENIE',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Chemo-mechaniczne opracowanie kanału o długości 20 mm Płukanie kanału NaOCl, kwasek cytrynowy, 0,9% NaCl. Ostateczne wypełnienie kanałów  Endomethasone + Gutaperka  Opatrunek Coltosol F. Kontrola RTG - kanał wypełniony prawidłowo.']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Endodoncja 2 kanały WYPEŁNIENIE'],
                ['name' => 'Endodoncja 2 kanały WYPEŁNIENIE',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Chemo-mechaniczne opracowanie kanałów o długości 20 mm  i 20 mm.Płukanie kanałów NaOCl, kwasek cytrynowy, 0,9% NaCl. Ostateczne wypełnienie kanałów  Endomethasone + Gutaperka  Opatrunek Coltosol F
Kontrola RTG - kanały wypełnione prawidłowo.']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Endodoncja 3 kanały WYPEŁNIENIE'],
                ['name' => 'Endodoncja 3 kanały WYPEŁNIENIE',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Chemo-mechaniczne opracowanie kanałów o długości 20 mm,20 mm  i 20 mm.Płukanie kanałów NaOCl, kwasek cytrynowy, 0,9% NaCl. Ostateczne wypełnienie kanałów  Endomethasone + Gutaperka  Opatrunek Coltosol F
Kontrola RTG - kanały wypełnione prawidłowo.']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => 'Ekstrakcja zęba mlecznego'],
                ['name' => 'Ekstrakcja zęba mlecznego',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => 'Ekstrakcja zęba mlecznego']
         
                );         
/*
        MedicalTemplate::updateOrCreate(
                ['name' => ''],
                ['name' => '',
                    'type' => MedicalTemplate::$typeQ, 
                    'desc' => '']
                );         

        MedicalTemplate::updateOrCreate(
                ['name' => ''],
                ['name' => '',
                    'type' => MedicalTemplate::$typeA, 
                    'desc' => '']
                );         
*/
    }
}
