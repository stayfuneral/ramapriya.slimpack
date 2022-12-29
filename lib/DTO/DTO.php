<?php

namespace Ramapriya\SlimPack\DTO;

use Ramapriya\SlimPack\Interfaces\DTO\DTOInterface;
use ReflectionProperty;
use Spatie\DataTransferObject\Arr;
use Spatie\DataTransferObject\DataTransferObject;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

abstract class DTO extends DataTransferObject implements DTOInterface
{
    private array $modifiedKeys = [];

    private NameConverterInterface $converter;

    public function __construct(array $parameters = [])
    {
        $this->converter = new CamelCaseToSnakeCaseNameConverter();
        $this->convertToCamelCase($parameters);
        parent::__construct($parameters);
    }

    public function convertToCamelCase(array &$parameters): void
    {
        $parameters = array_change_key_case($parameters);

        foreach ($parameters as $key => &$value) {
            $property = $this->converter->denormalize($key);

            if (! property_exists($this, $property)) {
                continue;
            }

            $propertyObject = new ReflectionProperty($this, $property);
            $type           = $propertyObject->getType()->getName();

            if ($type !== gettype($value) && is_scalar($type) && $value !== null) {
                settype($value, $type);
            } elseif (empty($value)) {
                $value = null;
            } elseif (gettype($type) === self::class) {
                $value = new $type($value);
            }

            $parameters[$property] = $value;

            if ($property !== $key) {
                unset($parameters[$key]);
            }
        }
    }

    public static function create(array $parameters): DataTransferObject
    {
        return new static($parameters);
    }

    public function convertToSnakeCase(): array
    {
        $data = [];

        foreach ($this->toArray() as $property => $value) {
            $field        = $this->converter->normalize($property);
            $field        = strtoupper($field);
            $data[$field] = $value;
        }

        return $data;
    }

    public function modify(array $parameters): void
    {
        $this->convertToCamelCase($parameters);

        foreach ($parameters as $key => $value) {
            if ($this->{$key} === $value) {
                continue;
            }

            $this->modifiedKeys[] = $key;
            $this->{$key}         = $value;
        }
    }

    public function modified(): DataTransferObject
    {
        $dto = clone $this;
        return $dto->only(...$this->modifiedKeys);
    }

    public function toString(): string
    {
        if (count($this->onlyKeys)) {
            $array = Arr::only($this->all(), $this->onlyKeys);
        } else {
            $array = Arr::except($this->all(), $this->exceptKeys);
        }

        $array = $this->parseArray($array);

        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }
}
