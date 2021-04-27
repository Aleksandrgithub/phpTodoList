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


## Методы

### create
```sh
Пример запроса: curl -i -X POST -H "Content-Type: application/json" -d "{\"description\":\"newTask\"}" http://localhost/phpTodoList/task/create.php
```

### read
```sh
Пример запроса: .../phpTodoList/todo/read.php
```

### update
```sh
Пример запроса: curl -i -X POST -H "Content-Type: application/json" -d "{\"id\":\"1\", \"status\":\"0\"}" http://localhost/phpTodoList/task/update.php
```

### delete
```sh
Пример запроса: curl -i -X POST -H "Content-Type: application/json" -d "{\"id\":\"1\"}" http://localhost/phpTodoList/task/delete.php
```

### readPaging
```sh
Пример запроса: .../phpTodoList/todo/readPaging.php
Посетить другую страницу: .../phpTodoList/todo/readPaging.php?page=2
Установить кол-во записей на странице: .../phpTodoList/todo/readPaging.php?records=2
Если кол-во записей не указано, дефолтное значение 5
```

## Дополнительные задачи

### Метод readCompleted
```sh
Пример запроса: .../phpTodoList/todo/readCompleted.php
```
