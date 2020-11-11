<?php

namespace App\Imports;

use App\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LeadsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Lead::create([
                'leadsource_id'    => $row[0],
                'name'     => $row[1],
                'email'    => $row[2],
                'mobile'    => $row[3],
                'project'    => $row[4],
                'budget'    => $row[5],
                'locality'    => $row[6],
                'leadstatus_id'    => 7,
                'remarks'    => $row[8],
                'user_id' => $row[8] ? $row[8] : Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
