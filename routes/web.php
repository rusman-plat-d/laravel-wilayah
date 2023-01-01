<?php

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::get(
    'province',
    function (Request $request) {
        $records = Wilayah::limit($request->limit ?? -1)
            ->get()
            ->filter(
                function ($record) {
                    return substr_count($record->kode, '.') == 0;
                }
            )
            ->map(
                function ($record) {
                    return [
                        'code'          => $record->kode,
                        'name'          => $record->nama,
                    ];
                }
            );
        return response()
            ->json(
                $records->values()
            );
    }
);

Route::get(
    'city',
    function (Request $request) {
        $records = Wilayah::limit($request->limit ?? -1)
            ->get()
            ->filter(
                function ($record) {
                    return substr_count($record->kode, '.') == 1;
                }
            )
            ->map(
                function ($record) {
                    return [
                        'parent_code'   => substr($record->kode, 0, strpos($record->kode, '.')),
                        'code'          => $record->kode,
                        'name'          => $record->nama,
                    ];
                }
            );
        return response()
            ->json(
                $records->values()
            );
    }
);

Route::get(
    'district',
    function (Request $request) {
        $records = Wilayah::limit($request->limit ?? -1)
            ->get()
            ->filter(
                function ($record) {
                    return substr_count($record->kode, '.') == 2;
                }
            )
            ->map(
                function ($record) {
                    $province_code = substr(
                        $record->kode,
                        0,
                        strpos(
                            $record->kode,
                            '.'
                        )
                    );
                    $code = str_replace($province_code . '.', '', $record->kode);
                    $parent_code = $province_code . '.' . substr(
                        $code,
                        0,
                        strpos(
                            $code,
                            '.'
                        )
                    );
                    return [
                        'parent_code'   => $parent_code,
                        'code'          => $record->kode,
                        'name'          => $record->nama,
                    ];
                }
            );
        return response()
            ->json(
                $records->values()
            );
    }
);

Route::get(
    'village',
    function (Request $request) {
        $records = Wilayah::limit($request->get('limit', -1) ?? -1)
            ->get()
            ->filter(
                function ($record) {
                    return substr_count($record->kode, '.') == 3;
                }
            )
            ->map(
                function ($record) {
                    $province_code = substr(
                        $record->kode,
                        0,
                        strpos(
                            $record->kode,
                            '.'
                        )
                    );
                    $code = str_replace($province_code . '.', '', $record->kode);
                    $district_code = $province_code . '.' . substr(
                        $code,
                        0,
                        strpos(
                            $code,
                            '.'
                        )
                    );
                    $code = str_replace($district_code . '.', '', $record->kode);
                    $parent_code = $district_code . '.' . substr(
                        $code,
                        0,
                        strpos(
                            $code,
                            '.'
                        )
                    );
                    return [
                        'parent_code'   => $parent_code,
                        'code'          => $record->kode,
                        'name'          => $record->nama,
                    ];
                }
            );
        return response()
            ->json(
                $records->values()
            );
    }
);
