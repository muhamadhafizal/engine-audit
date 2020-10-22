<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Submeter;

class SubmetersImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public function  __construct($projectid,$randnumber)
    {   
      
        $this->projectid= $projectid;
        $this->randnumber = $randnumber;
    }

    public function collection(Collection $collection)
    {
        $projectid = $this->projectid;
        $randnumber = $this->randnumber;

        $allarray = array();

        foreach($collection as $key=>$value){
            if($key > 0){
                    $temparray = [
                        'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[0])->format('Y-m-d'),
                        'time' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[1])->format('H:i:s'),
                        'power' => $value[2],
                    ]; 
                    array_push($allarray,$temparray);
            }
            
        }

        $formatdata = json_encode($allarray);

        $submeter = new Submeter;
        $submeter->projectid = $projectid;
        $submeter->randnumber = $randnumber;
        $submeter->value = $formatdata;
        $submeter->save();
    }
}
