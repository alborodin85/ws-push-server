TODO:

- Выпилить композер
- Убрать из https://packagist.org/
- Убрать command-getAuthToken.php
- Сделать Config.example.php
- Вынести handshake($connect), encode($payload), decode($data) в отдельный файл
- Вынести command-sendAll, command-sendMessage, Config, ws-push-server, public на верхний уровень
- Убрать папку example
- Из ws-push-server вынести адреса сокетов в Config.
- Статью на Хабр



# it5 websocket push sever

Простой websocket push server на php для небольших проектов.
В процессе участвуют браузер, БЭ-сервер и WS-сервер.
Браузер отправляет первый запрос на получение содержимого ФЭ.
БЭ-сервер делает запрос к WS-серверу, передает user_id и получает одноразовый auth_token.
БЭ-сервер отправляет браузеру auth_token и ссылку на подключение к WS-серверу.
Браузер подключается к ws и подписывается на канал.

## Установка

TODO:

## Использование

TODO:

## Принцип работы

TODO:

## Возможности масштабирования
- Перевод команд с сетевого сокета на файловый; \
- Запуск в нескольких процессах, но потребуется балансировщик на входе, который можно сделать либо на БЭ, либо отдельно. \

## Лицензия

The MIT License ([MIT](https://github.com/dnoegel/php-xdg-base-dir/blob/master/LICENSE)).
