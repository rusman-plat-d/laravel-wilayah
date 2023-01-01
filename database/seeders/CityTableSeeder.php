<?php

namespace Database\Seeders;

use App\Models\Master\Geo\City;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use File;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/json/city.json');
        $json = File::get($path);
        $data = json_decode($json);

        // $this->command->getOutput()->progressStart(count($data));
        $this->generate($data);
        // $this->command->getOutput()->progressFinish();
    }

    public function generate($data)
    {
        foreach ($data as $val) {
            $kab = City::where('province_id', $val->province_id)
                ->where('name', $val->name)
                ->first();
            if (!$kab) {
                $kab = new City;
            }
            $kab->id = $val->id;
            $kab->province_id = $val->province_id;
            $kab->code = $val->id;
            $kab->name = $val->name;
            $kab->created_by = $val->created_by;
            $kab->created_at = \Carbon\Carbon::now();
            $kab->save();
            // $this->command->getOutput()->progressAdvance();
        }
    }
}
