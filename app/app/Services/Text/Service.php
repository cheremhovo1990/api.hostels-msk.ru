<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 24.03.19
 * Time: 8:36
 */
declare(strict_types=1);


namespace App\Services\Text;


use App\Models\Organization\Lodge;
use App\Models\Organization\Property;

/**
 * Class Service
 * @package App\Services\Text
 */
class Service
{
    /**
     * @var Generate
     */
    private $generate;

    /**
     * @var array
     */
    protected $lodges = [
        'хостел',
        'hostel',
        'мини хостел',
        'мини-отель',
        'общежитие',
        'общежития эконом-класса',
        'общежитие гостиничного типа',
        'гостиница-хостел',
    ];

    /**
     * Service constructor.
     * @param Generate $generate
     */
    public function __construct(
        Generate $generate
    )
    {
        $this->generate = $generate;
    }

    /**
     * @param Lodge $lodge
     * @param $siteId
     */
    public function announce(Lodge $lodge, $siteId)
    {
        $options = [
        ];
        $variables = [];
        $variables['{city}'] = 'Москве';
        $this->name($lodge, $variables);
        $this->metro($lodge, $options, $variables);
        $this->hostel($lodge, $siteId, $variables);
        $this->wifi($lodge, $options, $variables);
        $lodge->announce = $this->generate->getText($options);
        $lodge->announce = $this->replace($variables, $lodge->announce);
    }

    /**
     * @param Lodge $lodge
     * @param $siteId
     * @param bool $hasMetro
     * @return string
     */
    public function title(Lodge $lodge, $siteId, bool $hasMetro): string
    {
        $variables = [];
        $this->name($lodge, $variables);
        $this->hostel($lodge, $siteId, $variables);
        $stations = $lodge->stations;
        $station = $stations->first();
        if ($hasMetro && !is_null($station)) {
            $variables['{metro}'] = $station->name;
            $title = '{Hostel} {name} {metro}';
        } else {
            $title = '{Hostel} {name}';
        }
        $title = $this->replace($variables, $title);
        return $title;
    }

    /**
     * @param array $variables
     * @param $text
     * @return string
     */
    public function replace(array $variables, $text): string
    {
        foreach ($variables as $variable => $value) {
            $text = str_replace($variable, $value, $text);
        }
        return $text;
    }

    /**
     * @param Lodge $lodge
     * @param $siteId
     * @param $variables
     */
    protected function hostel(Lodge $lodge, $siteId, &$variables)
    {
        $hostel = $this->lodges[$this->getIdentity($lodge, $siteId) % count($this->lodges)];
        $variables['{hostel}'] = $hostel;
        $variables['{Hostel}'] = mb_convert_case($hostel, MB_CASE_TITLE);
    }

    /**
     * @param Lodge $lodge
     * @param $variables
     */
    protected function name(Lodge $lodge, &$variables)
    {
        $variables['{name}'] = $lodge->organization->name;
    }

    /**
     * @param Lodge $lodge
     * @param $options
     * @param $variables
     */
    protected function metro(Lodge $lodge, &$options, &$variables)
    {
        $stations = $lodge->stations;
        $station = $stations->first();
        if (!is_null($station)) {
            $duration = (int)ceil($station->pivot->distance / 100);
            $distance = floor($station->pivot->distance / 100) * 100;
            $options['metro'] = true;
            $variables['{metro}'] = $station->name;
            $variables['{duration}'] = $duration;
            $variables['{distance}'] = $distance;
        }
    }

    /**
     * @param Lodge $lodge
     * @param $options
     * @param $variables
     */
    protected function wifi(Lodge $lodge, &$options, &$variables)
    {
        $properties = $lodge->properties;
        $wifi = $properties->reduce(function ($carry, Property $property) {
            if ($property->name == 'Wi-Fi') {
                return $property;
            }
            return $carry;
        });
        if (!is_null($wifi)) {
            $options['wi-fi'] = true;
        }
    }

    /**
     * @param Lodge $lodge
     * @param $siteId
     * @return int
     */
    protected function getIdentity(Lodge $lodge, $siteId): int
    {
        return $siteId + $lodge->id;
    }
}