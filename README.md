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
    ('Do housework'),
    ('Read a book'),
    ('Perform laboratory work'),
    ('Watch the video'),
    ('Take a walk'),
    ('Fix errors in pull request'),
    ('Reply to emails'),
    ('Take a walk with the dog'),
    ('Wash the dog'),
    ('Help friends'),
    ('Get some sleep')
```


## Методы

### create
```sh
Пример запроса: curl -i -X POST -H "Content-Type: application/json" -d "{\"description\":\"newTask\"}" http://localhost/phpTodoList/task/create.php
```

### read
```sh
Пример запроса: curl -i -X POST -H "Content-Type: application/json" -d "{\"id\":\"1\"}" http://localhost/phpTodoList/Todo/read.php
```

### readAll
```sh
Пример запроса: .../phpTodoList/Todo/readAll.php
```

### update
```sh
Пример запроса: curl -i -X POST -H "Content-Type: application/json" -d "{\"id\":\"1\", \"status\":\"0\"}" http://localhost/phpTodoList/Todo/update.php
```

### delete
```sh
Пример запроса: curl -i -X POST -H "Content-Type: application/json" -d "{\"id\":\"1\"}" http://localhost/phpTodoList/Todo/delete.php
```

### readPaging
```sh
Пример запроса: .../phpTodoList/Todo/readPaging.php
Посетить другую страницу: .../phpTodoList/Todo/readPaging.php?page=2
Установить кол-во записей на странице: .../phpTodoList/Todo/readPaging.php?records=2
Если кол-во записей не указано, дефолтное значение 5
```

## Дополнительные задачи

### Метод readCompleted
```sh
Пример запроса: .../phpTodoList/Todo/readCompleted.php
```
