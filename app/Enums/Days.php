<?php
namespace App\Enums;

class Days
{
    const SUNDAY    = 'Sunday';
    const MONDAY    = 'Monday';
    const TUESDAY   = 'Tuesday';
    const WEDNESDAY = 'Wednesday';
    const THURSDAY  = 'Thursday';
    const FRIDAY    = 'Friday';
   

    public static function all()
    {
        return [
            self::SUNDAY,
            self::MONDAY,
            self::TUESDAY,
            self::WEDNESDAY,
            self::THURSDAY,
            self::FRIDAY,
            
        ];
    }
}
