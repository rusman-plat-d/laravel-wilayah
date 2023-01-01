<?php

namespace Database\Seeders;

use App\Models\Master\Geo\District;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use File;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/json/district.json');
        $json = File::get($path);
        $data = json_decode($json);

        // $this->command->getOutput()->progressStart(count($data));
        $this->generate($data);
        // $this->command->getOutput()->progressFinish();
    }

    public function generate($data)
    {
        foreach ($data as $val) {
            $kec = District::where('city_id', $val->city_id)
                ->where('name', $val->name)
                ->first();
            if (!$kec) {
                $kec = new District;
            }
            $kec->id = $val->id;
            $kec->code = $val->id;
            $kec->city_id = $val->city_id;
            $kec->name = $val->name;
            $kec->created_by = $val->created_by;
            $kec->created_at = \Carbon\Carbon::now();
            $kec->save();
            // $this->command->getOutput()->progressAdvance();
        }
    }
}
