Проверка URL-адресов на доступность
===================================

Установите пакет, используя *Composer*:

``` composer install ratiborro/url-availability ```

Инициализируйте класс, передав массив URL-адресов для проверки в конструктор класса.

Для проверки URL-адресов используйте метод ```checkUrls()``` класса ```UrlAvailability```:

```php
use Ratiborro\UrlAvailability\UrlAvailability;
$checker = new UrlAvailability(['https://ratibor-korobin.ru', 'https://vk.com']);
$urls = $checker->checkUrls();
```

Метод ```checkUrls()``` вернёт массив Url-адресов в следующем формате:

```
[
    'all' => [], // Все проверяемые URL-адреса
    'available' => [], // Доступные URL-адреса
    'unavailable' => [], // Недоступные URL-адреса
]
```

---

Другие методы класса:

```all()``` - возвращает массив всех проверяемых URL-адресов

```availableUrls()``` - возвращает массив всех доступных URL-адресов

```unavailableUrls()``` - возвращает массив всех недоступных URL-адресов

```getErrors()``` - возвращает ассоциативный массив, в котором ключами являются недоступные URL-адреса, а значениями - код ответа сервера