<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Mainincoming;
class ExcelImport implements ToCollection
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

        //average here
        $count = 0;
        $total = 0;
        foreach($allarray as $data){
            $count = $count + 1;
            $total = $total + $data['power'];
        }
   
        $average = number_format($total/$count, 2, '.','');
        $peak =  $average;
       
        $mainincoming = new Mainincoming;
        $mainincoming->projectid = $projectid;
        $mainincoming->randnumber = $randnumber;
        $mainincoming->value = $formatdata;
        $mainincoming->peak = $peak;
        $mainincoming->save();
  
    }
}

