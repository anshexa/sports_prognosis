# Код для сайта на 1С-Битрикс

### *Описание задачи*
В инфоблоке "События" есть элементы - это "Матчи", есть разделы - "Лиги" и другие разделы.

**Задача** - сделать, чтобы страницы разделов-лиг участвовали в поиске на сайте.

## Что делает код

Данный код при переиндексации из инфоблока "События" пропускает в поисковый индекс  разделы-лиги, удаляет разделы, которые лигами не являются. Другие инфоблоки пропускает в индекс без изменений.

А так же модифицирует результат компонента поиска - для инфоблока "События"
разделяет найденные разделы и элементы на категории "Лиги" и "Матчи".