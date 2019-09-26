<?php

declare(strict_types=1);


namespace App\Models\Organization;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Property
 * @package App\Models\Organization
 * @property $lodge_id
 * @property $wi_fi
 * @property $reception_24_hour
 * @property $fridge
 * @property $television
 * @property $bunk_bed
 * @property $single_beds
 * @property $orthopedic_mattress
 * @property $daily_cleaning
 * @property $security_24_hour
 * @property $conditioner
 * @property $soundproofing
 * @property $kitchen
 * @property $bath
 * @property $shower
 * @property $washer
 * @property $drying_machine
 */
class Property extends Model
{
    const CHECKED_NO = 0;
    const CHECKED_YES = 1;

    public $primaryKey = 'lodge_id';
    public $timestamps = false;

    public function isWiFi(): bool
    {
        return $this->wi_fi === static::CHECKED_YES;
    }

    public function isReception24Hour(): bool
    {
        return $this->reception_24_hour === static::CHECKED_YES;
    }

    public function isFridge(): bool
    {
        return $this->fridge === static::CHECKED_YES;
    }

    public function isTelevision(): bool
    {
        return $this->television === static::CHECKED_YES;
    }

    public function isBunkBed(): bool
    {
        return $this->bunk_bed === static::CHECKED_YES;
    }

    public function isSingleBeds(): bool
    {
        return $this->single_beds === static::CHECKED_YES;
    }

    public function isOrthopedicMattress(): bool
    {
        return $this->orthopedic_mattress === static::CHECKED_YES;
    }

    public function isDailyCleaning(): bool
    {
        return $this->daily_cleaning === static::CHECKED_YES;
    }

    public function isSecurity24Hour(): bool
    {
        return $this->security_24_hour === static::CHECKED_YES;
    }

    public function isConditioner(): bool
    {
        return $this->conditioner === static::CHECKED_YES;
    }

    public function isSoundproofing(): bool
    {
        return $this->soundproofing === static::CHECKED_YES;
    }

    public function isKitchen(): bool
    {
        return $this->kitchen === static::CHECKED_YES;
    }

    public function isBath(): bool
    {
        return $this->bath === static::CHECKED_YES;
    }

    public function isShower(): bool
    {
        return $this->shower === static::CHECKED_YES;
    }

    public function isWasher(): bool
    {
        return $this->washer === static::CHECKED_YES;
    }

    public function isDryingMachine(): bool
    {
        return $this->drying_machine === static::CHECKED_YES;
    }
}
