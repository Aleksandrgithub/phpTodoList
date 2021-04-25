# phpTodoList

## База данных в phpMyAdmin

### Запрос на создание таблицы задач
```sh
CREATE TABLE IF NOT EXISTS `todo` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `description` text NOT NULL,
    `status` boolean NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Тестовые данные
```sh
INSERT INTO `todo` (`description`) VALUES
    ('Выполнить работу по дому'),
    ('Прочитать книгу'),
    ('Выполнить лабораторные работы'),
    ('Посмотреть видео'),
    ('Погулять'),
    ('Исправить ошибки в пулреквесте'),
    ('Ответить на письма'),
    ('Погулять с собакой'),
    ('Помыть собаку'),
    ('Помочь друзьям'),
    ('Выспаться')
```


## Methods

### create
```sh
Пример запроса: .../phpTodoList/todo/create.php?task=Новая задача
```
