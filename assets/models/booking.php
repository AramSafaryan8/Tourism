<?php
declare(strict_types = 1);

namespace Models;

use Models\Dbh;
use Models\Attributes\Extended;
use Models\Attributes\Extension;
use Models\IRetriever;

class Booking
    extends Dbh
    implements IRetriever
{
    private ?int $id;
    private ?int $userId;
    private ?int $tourId;
    private ?string $operationDate;
    protected const TABLENAME = 'bookings';

    public function __construct (?int $id = NULL, ?int $userId = NULL, ?int $tourId = NULL, ?string $operationDate = NULL) {
        $this->id = $id;
        $this->userId = $userId;
        $this->tourId = $tourId;
        $this->operationDate = $operationDate;
    }

    public static function create (int $userId, int $tourId) : ?self {
        $booking = new self();

        $booking->connect();

        $duplicate = $booking->get([
            'userId' => [
                'value' => $userId,
                'type' => \PDO::PARAM_INT
            ],
            'tourId' => [
                'value' => $tourId,
                'type' => \PDO::PARAM_INT
            ]
        ]);

        if (!empty($duplicate)) {
            $booking->close();

            return NULL;
        }

        $resp = $booking->query('INSERT INTO `' . self::TABLENAME . '` (`userId`, `tourId`) VALUES (' . $userId . ', ' . $tourId . ');');

        $booking->close();
        
        $booking = self::get_by([
            'userId' => ['value' => $userId, 'type' => \PDO::PARAM_INT],
            'tourId' => ['value' => $tourId, 'type' => \PDO::PARAM_INT]
        ])[0];

        return $booking;
    }

    public static function get_all () : array {
        $instance = new self();
        $bookings = NULL;

        $instance->connect();

        $resp = $instance->query('SELECT * FROM `' . self::TABLENAME . '`;');

        $instance->close();

        unset($instance);

        foreach ($resp as $booking) {
            $bookings[] = new self((int)$booking->id, (int)$booking->tourId, (int)$booking->userId, $booking->operationDate);
        }

        return $bookings;
    }

    public static function get_by (array $params) : array {
        $instance = new self();

        return $instance->get($params);
    }

    public function get_id () : ?int {
        return $this->id;
    }

    public function get_keys () : array {
        return (new \ReflectionClass(self::class))->getProperties(\ReflectionProperty::IS_PRIVATE);
    }

    public function get_operation_date () : ?string {
        return $this->operationDate;
    }

    public function get_tourId () : ?int {
        return $this->tourId;
    }

    public function get_userId () : ?int {
        return $this->userId;
    }

    public function retrieve (array $resp) : array {
        if (empty($resp)) {
            return $resp;
        }

        $bookings = [];
        $key = '';

        $rps = $this->get_keys();
        $rc = new \ReflectionClass($this);
        $arrRA = null;
        $isExtended = false;
        $isExtension = false;

        foreach ($resp as $index => $booking) {
            $bookings[] = new $this();

            foreach ($rps as $rp) {
                $arrRA = $rp->getAttributes();

                foreach ($arrRA as $attribute) {
                    if (Extended::class == $attribute->getName()) {
                        $isExtended = true;

                        break;
                    }

                    if (Extension::class == $attribute->getName()) {
                        $isExtension = true;

                        break;
                    }
                }

                if ($isExtension) {
                    $isExtension = false;

                    continue;
                }

                $key = $rp->name;

                if ($isExtended) {
                    $isExtended = false;
                    $value = $booking->$key;
                    $key = 'set_' . $key;

                    $this->$key($value);

                    continue;
                }

                $bookings[$index]->$key = self::cast($rc->getProperty($key)->getType()->getName(), $booking->$key);
            }
        }

        return $bookings;
    }
}