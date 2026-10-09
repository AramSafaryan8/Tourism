<?php
declare(strict_types = 1);

namespace Models;

use Models\Dbh;
use Models\Attributes\Extended;
use Models\Attributes\Extension;
use Models\IRetriever;

class Attraction
    extends Dbh
    implements IRetriever
{
    private ?int $id;
    private ?string $country;
    private ?string $title;
    private ?string $desc;
    private ?string $pic;
    protected const TABLENAME = 'attractions';

    public function __construct (?int $id = NULL, ?string $country = NULL, ?string $title = NULL, ?string $desc = NULL, ?string $pic = NULL) {
        $this->id = $id;
        $this->country = $country;
        $this->title = $title;
        $this->desc = $desc;
        $this->pic = $pic;
    }

    public static function get_all () : array {
        $instance = new self();
        $attractions = NULL;

        $instance->connect();

        $response = $instance->query('SELECT * FROM `' . self::TABLENAME . '`;');

        $instance->close();
        unset($instance);

        foreach ($response as $attraction) {
            $attractions[] = new self((int)$attraction->id, $attraction->country, $attraction->title, $attraction->desc, $attraction->pic);
        }

        return $attractions;
    }

    public static function get_by (array $params) : array {
        $instance = new self();

        return $instance->get($params);
    }

    public function get_country () : ?string {
        return $this->country;
    }

    public function get_desc () : ?string {
        return $this->desc;
    }

    public function get_id () : ?int {
        return $this->id;
    }
    
	public function get_keys () : array {		
		return (new \ReflectionClass(self::class))->getProperties(\ReflectionProperty::IS_PRIVATE);
    }

    public function get_title () : ?string {
        return $this->title;
    }

    public static function get_top (int $count) : array {
        $instance = new self();

        $instance->connect();

        $attractions = $instance->query('SELECT * FROM `' . self::TABLENAME . '` LIMIT ' . $count . ';');

        foreach ($attractions as $key => $attraction) {
            $attractions[$key] = new self((int)$attraction->id, $attraction->country, $attraction->title, $attraction->desc, $attraction->pic);
        }

        $instance->close();

        return $attractions;
    }

    public function get_pic () : ?string {
        return $this->pic;
    }

    public function retrieve (array $resp) : array {
        if (empty($resp)) {
            return $resp;
        }

        $attractions = [];
        $key = '';

        $rps = $this->get_keys();
        $rc = new \ReflectionClass($this);
        $arrRA = null;
        $isExtended = false;
        $isExtension = false;

        foreach ($resp as $index => $attraction) {
            $attractions[] = new $this();

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
                    $value = $attraction->$key;
                    $key = 'set_' . $key;

                    $this->$key($value);

                    continue;
                }

                $attractions[$index]->$key = self::cast($rc->getProperty($key)->getType()->getName(), $attraction->$key);
            }
        }

        return $attractions;
    }
}