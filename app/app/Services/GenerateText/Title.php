<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 21.02.19
 * Time: 10:48
 */
declare(strict_types=1);


namespace App\Services\GenerateText;


use App\Http\Resources\Lodge;

class Title
{
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
     * @var GenerateText
     */
    private $generateText;

    public function __construct(
        GenerateText $generateText
    )
    {
        $this->generateText = $generateText;
    }

    public function generate(): string
    {
        $organizationName = $this->generateText->getOrganization()->name;
        $title = mb_convert_case($this->lodges[$this->generateText->getIdentity() % count($this->lodges)], MB_CASE_TITLE);
        return "$title \"{$organizationName}\"";
    }
}