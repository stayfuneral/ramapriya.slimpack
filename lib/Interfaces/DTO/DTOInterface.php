<?php

namespace Ramapriya\SlimPack\Interfaces\DTO;

use Spatie\DataTransferObject\DataTransferObject;

interface DTOInterface
{
    /**
     * Фабричный метод создания DTO
     *
     * @param array $parameters
     *
     * @return DataTransferObject
     */
    public static function create(array $parameters): DataTransferObject;

    /**
     * Подготовка параметров для передачи в DataTransferObject
     * Конвертация из SNAKE_CASE в camelCase
     *
     * @param array $parameters
     *
     * @return void
     */
    public function convertToCamelCase(array &$parameters): void;

    /**
     * Конвертация из camelCase в SNAKE_CASE
     *
     * @return array
     */
    public function convertToSnakeCase(): array;

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
