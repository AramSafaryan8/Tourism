<?php
declare(strict_types = 1);

namespace Models;

use Models\Dbh;
use Models\Attributes\Extended;
use Models\Attributes\Extension;
use Models\IRetriever;

class Tour
    extends Dbh
    implements IRetriever
{
    private ?int $id;
    private ?string $country;
    private ?array $destinations;
    #[Extended]
    private ?string $date;
    #[Extension]
    private ?string $time;
    private ?int $duration;
    private ?string $pic;
    protected const TABLENAME = 'tours';

    public function __construct (?int $id = NULL, ?string $country = NULL, ?string $destinations = NULL, ?string $date = NULL, ?int $duration = NULL, ?string $pic = NULL) {
        $this->id = $id;
        $this->country = $country;
        $this->destinations = ($destinations) ? explode(',', $destinations) : $destinations;
        $this->set_date($date);
        $this->duration = (int)$duration;
        $this->pic = $pic;
    }

    public static function get_all () : array {
        $instance = new self();
        $tours = NULL;

        $instance->connect();

        $resp = $instance->query('SELECT * FROM `' . self::TABLENAME . '`;');

        $instance->close();

        unset($instance);

        foreach ($resp as $tour) {
            $tours[] = new self((int)$tour->id, $tour->country, $tour->destinations, $tour->date, $tour->duration, $tour->pic);
        }

        return $tours;
    }

    public static function get_by (array $params) : array {
        $instance = new self();

        return $instance->get($params);
    }

    private function set_date (?string $value) : void {
        $this->date = $value;
        $this->time = ($this->date) ? substr(explode(' ', $this->date)[1], 0, -3) : $this->date;
    }

    public function get_country () : ?string {
        return $this->country;
    }

    public function get_date () : ?string {
        return $this->date;
    }

    public function get_destinations () : ?array {
        return $this->destinations;
    }

    public function get_duration () : ?int {
        return $this->duration;
    }

    public function get_id () : ?int {
        return $this->id;
    }
    
	public function get_keys () : array {
		return (new \ReflectionClass(self::class))->getProperties(\ReflectionProperty::IS_PRIVATE);
    }

    public function get_pic () : ?string {
        return $this->pic;
    }

    public function get_time () : ?string {
        return $this->time;
    }

    public function retrieve (array $resp) : array {
        if (empty($resp)) {
            return $resp;
        }

        $tours = [];
        $key = '';
        $value = NULL;

        $rps = $this->get_keys();
        $rc = new \ReflectionClass($this);
        $arrRA = null;
        $isExtended = false;
        $isExtension = false;

        foreach ($resp as $index => $tour) {
            $tours[] = new $this();

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

                    $value = $tour->$key;
                    $key = 'set_' . $key;

                    $tours[$index]->$key($value);

                    continue;
                }

                $tours[$index]->$key = self::cast($rc->getProperty($key)->getType()->getName(), $tour->$key);
            }
        }

        return $tours;
    }
}