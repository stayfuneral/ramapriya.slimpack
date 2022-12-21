<?php

namespace Ramapriya\SlimPack\DTO;

use Ramapriya\SlimPack\Interfaces\DTO\DTOInterface;
use ReflectionProperty;
use Spatie\DataTransferObject\DataTransferObject;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

abstract class DTO extends DataTransferObject implements DTOInterface
{
    public function __construct(array $parameters = [])
    {
        $this->prepareParameters($parameters);
        parent::__construct($parameters);
    }

    /**
     * Подготовка параметров для передачи в DataTransferObject
     * Конвертация из SNAKE_CASE в camelCase
     *
     * @param array $parameters
     *
     * @return void
     */
    public function prepareParameters(array &$parameters): void
    {
        $converter  = new CamelCaseToSnakeCaseNameConverter();
        $parameters = array_change_key_case($parameters);

        foreach ($parameters as $key =>&$value) {
            $property = $converter->denormalize($key);

            if (!property_exists($this, $property)) {
                continue;
            }

            $propertyObject = new ReflectionProperty($this, $property);
            $type = $propertyObject->getType()->getName();

            if ($type !== gettype($value) && is_scalar($type)) {
                settype($value, $type);
            } elseif (gettype($type) === self::class) {
                $value = new $type($value);
            }

            $parameters[$property] = $value;

            if ($property !== $key) {
                unset($parameters[$key]);
            }
        }
    }

    /**
     * Фабричный метод создания DTO
     *
     * @param array $parameters
     *
     * @return DTOInterface
     */
    public static function create(array $parameters): DTOInterface
    {
        return new static($parameters);
    }
}
