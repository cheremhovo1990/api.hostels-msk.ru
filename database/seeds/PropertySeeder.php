<?php

use App\Models\Organization\Property;
use App\Models\Organization\PropertyGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            'Удобства' => [
                'Wi-Fi',
                'Парковка',
                'Круглосуточная стойка регистрации',
                'Холодильник',
                'Телевизор',
                'Шкаф для хранения верхней одежды',
                'Двухъярусные кровати с ортопедическими матрасами',
                'Ежедневная уборка',
                'Чистое постельное белье',
                'Круглосуточная охрана',
                'Кондиционер',
                'Шумоизоляция',
                'Кухня/мини-кухня',
                'Ванна',
                'Стиральная машина',
            ],
        ];
        DB::delete('delete from properties');
        DB::delete('delete from property_groups');
        foreach ($groups as $name => $properties) {
            $group = PropertyGroup::create([
                'name' => $name,
            ]);

            foreach ($properties as $property) {
                Property::create([
                    'group_id' => $group->id,
                    'name' => $property
                ]);
            }

        }
    }
}
