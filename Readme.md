#  Simple Notes

##### Это простое приложение для управления заметками,использующее архитектуру MVC.

## Стек технологий

- **PHP**
- **MySQL**

## Установка

1. `Клонировать репозиторий: ```bash https://github.com/Nixonnes/SimpleNotes.git ```
2. Установить зависимости: ```composer install ```
3. Настроить подключение к базе данных
4. Импортировать структуру базы данных( ```CREATE TABLE notes (
   id INT AUTO_INCREMENT PRIMARY KEY,
   title VARCHAR(255) NOT NULL,
   content TEXT,
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );```)
5. Запустить проект.

## Использование

1. Перейдите на главную страницу для просмотра списка заметок.
2. Добавьте новую заметку с помощью формы.
3. Редактируйте или удаляйте заметки по мере необходимости.

## Архитектура приложения

###### Проект построен с использованием архитектуры MVC (Model-View-Controller):
### 1.  Model 
Отвечает за работу с данными.В данном проекте модель представлена базовым классом Model,
который содержит общие методы для работы с базой данных.
### 2.View
Отображает данные пользователю. Все представления находятся в папке views. Шаблоны использует переменные, переданные из контроллеров.
### 3.Controller
Управляет запросами от пользователей и определяет, какие данные нужно показать, обработать или изменить. Контроллеры находятся в папке controllers.