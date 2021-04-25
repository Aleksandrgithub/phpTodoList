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
Пример запроса: .../phpTodoList/todo/create.php?task=Новая задача
```

### read
```sh
Пример запроса: .../phpTodoList/todo/read.php
```

### update
```sh
Пример запроса: .../phpTodoList/todo/update.php?id=1&status=0
```

### delete
```sh
Пример запроса: .../phpTodoList/todo/delete.php?id=1
```

### readPaging
```sh
Пример запроса: .../phpTodoList/todo/readPaging.php
Посетить другую страницу: .../phpTodoList/todo/readPaging.php?page=2
Установить кол-во записей на странице: .../phpTodoList/todo/readPaging.php?records=2
```

## Дополнительные задачи

### Метод readCompleted
### delete
```sh
Пример запроса: .../phpTodoList/todo/readCompleted.php
```
