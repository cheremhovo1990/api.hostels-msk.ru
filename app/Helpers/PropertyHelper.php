<?php

declare(strict_types=1);


namespace App\Helpers;


class PropertyHelper
{
    public static function getDropDown()
    {
        return [
            [
                'name' => 'wi_fi',
                'label' => 'Wi-Fi'
            ],
            [
                'name' => 'reception_24_hour',
                'label' => 'Круглосуточная стойка регистрации'
            ],
            [
                'name' => 'fridge',
                'label' => 'Холодильник'
            ],
            [
                'name' => 'television',
                'label' => 'Телевизор'
            ],
            [
                'name' => 'bunk_bed',
                'label' => 'Двухъярусные кровати'
            ],
            [
                'name' => 'single_beds',
                'label' => 'Одноярусные кровати'
            ],
            [
                'name' => 'orthopedic_mattress',
                'label' => 'Ортопедические матрасы'
            ],
            [
                'name' => 'daily_cleaning',
                'label' => 'Ежедневная уборка'
            ],
            [
                'name' => 'security_24_hour',
                'label' => 'Круглосуточная охрана'
            ],
            [
                'name' => 'conditioner',
                'label' => 'Кондиционер'
            ],
            [
                'name' => 'soundproofing',
                'label' => 'Шумоизоляция'
            ],
            [
                'name' => 'kitchen',
                'label' => 'Кухня'
            ],
            [
                'name' => 'bath',
                'label' => 'Ванна'
            ],
            [
                'name' => 'shower',
                'label' => 'Душ'
            ],
            [
                'name' => 'washer',
                'label' => 'Стиральная машина'
            ],
            [
                'name' => 'drying_machine',
                'label' => 'Сушильная машина'
            ],
        ];
    }
}
