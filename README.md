# Написать symfony REST приложение для рассчета цены продукта и проведения оплаты

Необходимо написать 2 эндпоинта:
- POST: для расчёта цены
- POST: для выполнения покупки

Пример json тела запроса:

```
{
    "product": "1",
    "taxNumber": "DE123456789",
    "couponCode": "D15",
    "paymentProcessor": "paypal"
}
```

При успешном выполнении запроса вернуть HTTP ответ с кодом 200

При неверных входных данных или ошибках оплаты вернуть HTTP ответ с кодом 400 и json объект с ошибками

## Продукты
- Iphone (100 евро)
- Наушники (20 евро)
- Чехол (10 евро)

## Купоны
При наличии купона покупатель может применить его к покупке
Купон может быть двух типов:
- фиксированная сумма скидки
- процент от суммы покупки

## Расчет налога
При покупке продукта получатель сверх цены продукта должен уплатить налог, относительно страны налогового номера:
- Германии - 19%
- Италии - 22%
- Франции - 20%
- Греции - 24%

В итоге для покупателя Iphone из Греции цена составляет 124 евро (цена продукта 100 евро + налог 24%).
Если у покупателя есть купон на 6% скидку на покупку, то цена будет 116.56 евро (цена продукта 100 евро - 6% скидка + налог 24%)

## Формат налогового номера
DEXXXXXXXXX - для жителей Германии

ITXXXXXXXXXXX - для жителей Италии

GRXXXXXXXXX - для жителей Греции,

FRYYXXXXXXXXX - для жителей Франции

где:
- первые два символа - это код страны
- X - любая цифра от 0 до 9,
- Y - любая буква

Обратите внимание, что длина налогового номера разная для разных стран.
Форматы налоговых номеров могут меняться, что случается редко (Это зависит от законодательства)

## Детали
При выполнении задания нужно:
- проверить корректность tax номера,
- рассчитать итоговую цену покупки вместе с купоном (если указан) и налогом,
- для проведения платежа используйте `PaypalPaymentProcessor::pay` или `StripePaymentProcessor::processPayment`
  Оба класса прилагаются, скопируйте их себе в проект.
  Для простоты представьте, что эти два класса входят в два разных сторонних SDK, и у вас **нет возможности править эти классы или какую-либо логику внутри них**.

Необходимо использовать Symfony Form, Validator

CRUD для сущностей писать не нужно

При написании тестового используйте git, после выполнения пришлите ссылку на репозиторий.

Необходимо учесть возможность добавления новых PaymentProcessors.

### Желательно
- использовать контейнеризацию для php, nginx, postgres/mysql
- PHP Unit test
- применение SOLID принципов
- реализация задания в несколько коммитов приветствуется

### Prerequisite

- Docker >=20.10.14
- Docker Compose >=v1.29.0

### Local environment setup

1.save .env.local file as .env in root directory

2.building Docker images
```
docker-compose build
```
3.Create and start containers
```
docker-compose up -d
```

4.Install dependencies
```
docker-compose exec app composer install
```

5.Running migrations
```
docker-compose exec app php bin/console doctrine:migrations:migrate
```

### URLs

```
http://localhost:1234/api/doc
```
