## С чем столкнулся

Для выполнеия задания пришлось с нуля изучать Laravel. Инструмент понравился, но из-за ограниченного 
времени в процессе получились некоторые косяки:

- Поздно заметил, что авторов у статьи может быть несколько. В скрипте сохраняю только первого;
- В NewsSeeder не сходу не придумал, как соотносить id категорий и значения, поэтому захардкодил;
- Не знаком с стайлгайдом по ларавелу, поэтому некоторые названия папок и файлов могут быть не правильно названы. 
По этой же причине, результаты парсинга складывал в папке resources;
- Вместо longText использовал поле Text у новости, поэтому текст в базе укороченный 
(полный размер в файле) (поленился исправлять);
- Возможно, что то ещё забыл;

## TODO

Вынести парсинг в отдельный контроллер или хелпер
