<?php
declare(strict_types = 1);

namespace Scripts;

class Calendar
{
    public static function get_day_period (string $time) : string {
        return ((int)explode(':', $time)[0] > 12) ? 'PM' : 'AM';
    }

    public static function get_month_name (int $monthNumber) : string {
        switch ($monthNumber) {
            case 1:
                return 'January';
            case 2:
                return 'February';
            case 3:
                return 'March';
            case 4:
                return 'April';
            case 5:
                return 'May';
            case 6:
                return 'June';
            case 7:
                return 'July';
            case 8:
                return 'August';
            case 9:
                return 'September';
            case 10:
                return 'October';
            case 11:
                return 'November';
            case 12:
                return 'December';
            default:
                return 'N/A';
                break;
        }
    }
}