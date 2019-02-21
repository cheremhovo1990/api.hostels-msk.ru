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
     * @var array
     */
    public $list = [
        'Уютное и просторное в {duration} мин. пешком от метро!',
        'Удобное расположение – находится рядом с метро, в шаговой доступности',
        '{duration} минутах ходьбы от метро! Выгодное расположение не заставит вас долго искать наш хостел',
        '{title} находится в {duration} минутах ходьбы от {metro}',
    ];

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

    /**
     * @return int
     */
    public function getDuration(): int
    {
        $station = $this->generateText->getMetroStation();
        $distance = $station->pivot->distance;
        return (int)ceil($distance / 100);
    }

    /**
     * @return string
     */
    public function getMetro(): string
    {
        $text = $this->list[3];
        $duration = $this->getDuration();
        $metro = 'м. ' . $this->generateText->getMetroStation()->name;
        $title = $this->generateText->getTitle();
        $text = str_replace([
            '{duration}',
            '{metro}',
            '{title}'
        ], [
            $duration,
            $metro,
            $title
        ], $text);
        return $text;
    }
}