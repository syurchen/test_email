# test_email
1) Для верификации был взят уже готовый класс из https://github.com/nsgeorgi/verify-email
  Он осуществляет HELO к SMTP хосту и проверяет наличие ящика. Также в нём есть валидация регуляркой
 2) В БД было добавлено поле-флаг [ alter table test_emails add verified tinyint(1); ]. Написанный мной класс проверяет это поле и проставляет его по результатам проверки
 3) Возможны проблемы с кириллицей при некоторых настройках БД, но я не стал мучиться с этим
 4) На задание потратил 1.5 часа
