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
        'Удобное расположение – находится рядом с метро {metro}, в шаговой доступности.',
        '{duration} минутах ходьбы от метро {metro}! Выгодное расположение не заставит вас долго искать наш хостел.',
        '{title} находится в {duration} минутах ходьбы от м. {metro}.',
        'От станции м. {metro} - {duration} минут пешком до гостиницы.',
        'От метро {metro} - {duration} мин. хотьбы до хостела, что позволяет гостям передвигаться с минимальной затратой времени.',
        'Хостел удобно расположен рядом со станции метро {metro}.',
        'Общежитие расположен около со станциями м. {metro}.',
        'Близкое расположение от метро {metro}.',
        'Общежитие "{name}" расположено в шаге от м. {metro} в спокойном районе.',
        'Удачное расположение гостиницы позволяет дойти от станции метро "{metro}" за {duration} минут',
        'Уютное и просторное общежитие коридорного типа в {duration} мин. ходьбы от метро {metro}',
        'Общежитие у метро "{metro}", это небольшое, уютное, тихое общежитие.',
        'В районе метро "{metro}" расположено дешёвое, но уютное общежитие коридорного типа.',
        'Мы находимся  в {duration} мин. ходьбы от станции метро {metro}',
        'Удобное расположение и низкие цены делают общежитие в районе метро {metro} любимым местом проживания.',
        'Небольшая уютная гостиница неподалеку от станции метро {metro}.',
        'Удобное расположение в {distance} метрах от метро {metro}.', // TODO not variable distance
        'Удобное расположение, рядом с метро {metro}.',
        'Рядом метро и {metro}.',
        'Удобное расположение относительно метро {metro} и остановок.',
        'Недалеко от метро {metro}.',
        'Удобное расположение гостиницы в {duration} мин. от станции метро {metro}.',
        'Отель {name}, расположенный в шаговой доступности от станции метро {metro}.',
        'Мини-отель находится в пешей доступности от метро {metro}.',
        'Ближайшая станция метро {metro} находится всего в {duration} мин. ходьбы от {name}',
        'Хостел расположен в {duration} мин. ходьбы от м. {metro}.'
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
        $metro = $this->generateText->getMetroStation()->name;
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