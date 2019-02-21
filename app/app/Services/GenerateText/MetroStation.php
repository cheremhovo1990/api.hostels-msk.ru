<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 21.02.19
 * Time: 11:02
 */
declare(strict_types=1);


namespace App\Services\GenerateText;


/**
 * Class MetroStation
 * @package App\Services\GenerateText
 */
class MetroStation
{
    /**
     * @var array
     */
    public $metro = [
        'м.',
        'метро'
    ];

    /**
     * @var array
     */
    public $nearMetro = [
        'рядом c',
        'около',
        'возле',
    ];

    /**
     * @var GenerateText
     */
    private $generateText;


    /**
     * MetroStation constructor.
     * @param GenerateText $generateText
     */
    public function __construct(
        GenerateText $generateText
    )
    {
        $this->generateText = $generateText;
    }

    /**
     * @return string
     */
    public function generateForTitle(): string
    {
        $stationName = $this->generateText->getMetroStation()->name;
        $metro = $this->metro[$this->generateText->getIdentity() % count($this->metro)];
        $nearMetro = $this->nearMetro[$this->generateText->getIdentity() % count($this->nearMetro)];
        return "{$nearMetro} {$metro} {$stationName}";
    }
}