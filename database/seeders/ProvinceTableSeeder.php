<?php

namespace Database\Seeders;

use App\Models\Master\Geo\Province;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use File;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/json/province.json');
        $json = File::get($path);
        $data = json_decode($json);

        // $this->command->getOutput()->progressStart(count($data));
        $this->generate($data);
        // $this->command->getOutput()->progressFinish();
    }

    public function generate($data)
    {
        foreach ($data as $val) {
            $prov = Province::where('name', $val->name)->first();
            if (!$prov) {
                $prov = new Province;
            }
            $prov->id = $val->id;
            $prov->code = $val->id;
            $prov->name = $val->name;
            $prov->created_by = 1;
            $prov->created_at = \Carbon\Carbon::now();
            $prov->save();
            // $this->command->getOutput()->progressAdvance();
        }
    }
}
