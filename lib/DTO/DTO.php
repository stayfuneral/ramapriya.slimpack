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
    protected array $modifiedKeys = [];

    protected NameConverterInterface $converter;

    public function __construct(array $parameters = [], bool $convertToCamel = false, bool $keysToLower = false)
    {
        $this->converter = new CamelCaseToSnakeCaseNameConverter();

        if ($convertToCamel) {
            $this->convertToCamelCase($parameters, $keysToLower);
        }

        $this->prepareParameters($parameters);

        parent::__construct($parameters);
    }

    public function convertToCamelCase(array &$parameters, bool $keysToLower = true): void
    {
        if ($keysToLower) {
            $parameters = array_change_key_case($parameters);
        }

        foreach ($parameters as $key => &$value) {
            $property              = $this->converter->denormalize($key);
            $parameters[$property] = $value;

            if ($property !== $key) {
                unset($parameters[$key]);
            }
        }
    }

    public function prepareParameters(array &$parameters)
    {
        foreach ($parameters as $property => $value) {
            if (! property_exists($this, $property)) {
                dump($property, $value);
                unset($parameters[$property]);
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
        }
    }

    public static function create(array $parameters, bool $convertToCamel = false, bool $keysToLower = false): DataTransferObject
    {
        return new static($parameters);
    }

    public function convertToSnakeCase(bool $keysToUpper = false): array
    {
        $data = [];

        foreach ($this->toArray() as $property => $value) {
            $field        = $this->converter->normalize($property);
            $data[$field] = $value;
        }

        return $keysToUpper ? array_change_key_case($data, CASE_UPPER) : $data;
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
