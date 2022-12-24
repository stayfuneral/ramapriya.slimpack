# Bitrix Slim pack

Модуль для использования фреймворка Slim в проектах на 1С-Битрикс

### Предназначение

Модуль подходит для реализации API на Битрикс и даёт возможность использовать роутинг, контроллеры, DTO, мидлвейры, сервисы и т.д.

## Установка

### Установка через composer

Прежде, чем устанавливать модуль, в `composer.json` добавьте следующий код:

```json
"extra": {
        "installer-paths": {
            "path/to/modules/{$name}": [
                "type:bitrix-module",
                "type:bitrix-d7-module"
            ]
        }
    }
```

где `path/to/modules` - путь к модулям относительно `composer.json`

Далее выполните команду

`composer require stayfuneral/ramapriya.slimpack`

### Клонирование репозитория

Перейдите в папку с модулями (обычно это `local/modules`) и выполните команду

`git clone https://github.com/stayfuneral/ramapriya.slimpack.git`

После установки файлов в админке в разделе `Рабочий стол >> Marketplace >> Установленные решения` установите модуль
