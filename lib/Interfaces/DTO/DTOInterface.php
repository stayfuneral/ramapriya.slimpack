<?php

namespace Ramapriya\SlimPack\Interfaces\DTO;

use Spatie\DataTransferObject\DataTransferObject;

interface DTOInterface
{
    /**
     * Фабричный метод создания DTO
     *
     * @param array $parameters
     * @param bool  $convertToCamel - Флаг необходимости конвертации ключей в camelCase
     * @param bool  $keysToLower - Флаг необходимости приведения ключей к нижнему регистру
     *
     * @return DataTransferObject
     */
    public static function create(array $parameters, bool $convertToCamel = false, bool $keysToLower = false): DataTransferObject;

    /**
     * Подготовка параметров для передачи в DataTransferObject
     * Конвертация из SNAKE_CASE в camelCase
     *
     * @param array $parameters
     * @param bool  $keysToLower - Флаг необходимости приведения ключей к нижнему регистру
     *
     * @return void
     */
    public function convertToCamelCase(array &$parameters, bool $keysToLower = true): void;

    /**
     * Конвертация из camelCase в SNAKE_CASE
     *
     * @param bool $keysToUpper - Флаг необходимости приведения ключей к верхнему регистру
     *
     * @return array
     */
    public function convertToSnakeCase(bool $keysToUpper = false): array;

    /**
     * Изменение свойств DTO
     *
     * @param array $parameters
     *
     * @return void
     */
    public function modify(array $parameters): void;

    /**
     * Получение только изменённых свойств
     * @return DataTransferObject
     */
    public function modified(): DataTransferObject;

    /**
     * Форматирование объекта в строку
     * @return string
     */
    public function toString(): string;
}
