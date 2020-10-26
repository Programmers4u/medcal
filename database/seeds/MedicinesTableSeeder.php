<?php

use Illuminate\Database\Seeder;

class MedicinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = $this->getFromFile();
        foreach ($records as $inx=>$record) {
            try{
            $rec = explode(";", $record);
            if(empty($rec[0]) || empty($rec[1]) || !$rec[0] || !$rec[1]) continue;
            $query = [
                'name' => $rec[0],
            ];
            $update = [
                'name' => $rec[0],
                'shortname' => $rec[1],
                'power' => $rec[2],
                'shape' => $rec[3],
                'no_permission' => $rec[4],
                'permission_expaired' => $rec[5],
                'company' => $rec[6],
                'type' => $rec[7],
                'code' => $rec[8]
            ];
            try{
            $result = \App\Models\MedicalMedicines::updateOrCreate($query,$update);
            }catch(Exception $e){
                logger($e->getMessage());
            }
            }catch(Exception $e){
                logger($e->getMessage());
            }
        }
    }
    
    private function getFromFile(){
        $filename = dirname(__FILE__).'/seed_file/medicines.csv';
        $fb = file_get_contents($filename); 
        return explode("\n", $fb);
    }
}
