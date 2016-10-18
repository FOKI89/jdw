<?php
namespace AppBundle\Enum;

class Gender
{
    const MALE = 1;
    const FEMALE = 2;
    const UNKNOWN = 3;

    public static function getChoices()
    {
        return array(
            'male' => self::MALE,
            'female' => self::FEMALE,
            'unknown' => self::UNKNOWN,
        );
    }
}