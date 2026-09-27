<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkUnit;

class WorkUnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['code' => '0021', 'name' => 'KC JEMBER', 'type' => 'Kantor Cabang'],
            ['code' => '1161', 'name' => 'KCP AMBULU', 'type' => 'Kantor Cabang Pembantu'],
            ['code' => '2203', 'name' => 'KCP KOTA JEMBER', 'type' => 'Kantor Cabang Pembantu'],
            ['code' => '6212', 'name' => 'UNIT JENGGAWAH', 'type' => 'Unit'],
            ['code' => '6213', 'name' => 'UNIT ARJASA', 'type' => 'Unit'],
            ['code' => '6214', 'name' => 'UNIT GUMUK MAS', 'type' => 'Unit'],
            ['code' => '6215', 'name' => 'UNIT KALISAT', 'type' => 'Unit'],
            ['code' => '6216', 'name' => 'UNIT SEMPUSARI', 'type' => 'Unit'],
            ['code' => '6217', 'name' => 'UNIT SUMBERJATI', 'type' => 'Unit'],
            ['code' => '6218', 'name' => 'UNIT TEMPUREJO', 'type' => 'Unit'],
            ['code' => '6219', 'name' => 'UNIT UMBULSARI', 'type' => 'Unit'],
            ['code' => '6220', 'name' => 'UNIT AMBULU', 'type' => 'Unit'],
            ['code' => '6221', 'name' => 'UNIT BALUNG LOR', 'type' => 'Unit'],
            ['code' => '6222', 'name' => 'UNIT DUKUH DEMPOK', 'type' => 'Unit'],
            ['code' => '6223', 'name' => 'UNIT GAJAH MADA', 'type' => 'Unit'],
            ['code' => '6224', 'name' => 'UNIT KASIYAN', 'type' => 'Unit'],
            ['code' => '6225', 'name' => 'UNIT KENCONG', 'type' => 'Unit'],
            ['code' => '6226', 'name' => 'UNIT PUGER', 'type' => 'Unit'],
            ['code' => '6227', 'name' => 'UNIT RAMBIPUJI', 'type' => 'Unit'],
            ['code' => '6228', 'name' => 'UNIT TANGGUL KULON', 'type' => 'Unit'],
            ['code' => '6229', 'name' => 'UNIT TANJUNG', 'type' => 'Unit'],
            ['code' => '6230', 'name' => 'UNIT AJUNG MANGLI', 'type' => 'Unit'],
            ['code' => '6231', 'name' => 'UNIT BANGSALSARI', 'type' => 'Unit'],
            ['code' => '6232', 'name' => 'UNIT JOMBANG', 'type' => 'Unit'],
            ['code' => '6233', 'name' => 'UNIT MAYANG', 'type' => 'Unit'],
            ['code' => '6234', 'name' => 'UNIT SABRANG', 'type' => 'Unit'],
            ['code' => '6235', 'name' => 'UNIT SEMBORO', 'type' => 'Unit'],
            ['code' => '6236', 'name' => 'UNIT SERUT', 'type' => 'Unit'],
            ['code' => '6237', 'name' => 'UNIT SUKOWONO', 'type' => 'Unit'],
            ['code' => '6238', 'name' => 'UNIT WIROLEGI', 'type' => 'Unit'],
            ['code' => '6239', 'name' => 'UNIT YOSORATI', 'type' => 'Unit'],
            ['code' => '7447', 'name' => 'UNIT LEDOKOMBO', 'type' => 'Unit'],
            ['code' => '7480', 'name' => 'UNIT MUMBULSARI', 'type' => 'Unit'],
            ['code' => '7525', 'name' => 'UNIT TEGAL BESAR', 'type' => 'Unit'],
            ['code' => '7526', 'name' => 'UNIT SUMBERJAMBE', 'type' => 'Unit'],
            ['code' => '7746', 'name' => 'UNIT TANGGUL II', 'type' => 'Unit'],
            ['code' => '7748', 'name' => 'UNIT PATRANG', 'type' => 'Unit'],
        ];

        WorkUnit::query()->delete();

        foreach ($units as $unit) {
            WorkUnit::create($unit);
        }
    }
}
