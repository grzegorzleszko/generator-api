# generator-api

Końcówka /production/create przyjmuje POST z json:
```json
{
    "generatorId": 1,
    "power": 34.123,
    "dateFrom": "2020-08-15T15:52:01.123",
    "dateTo": "2020-08-15T15:52:02.666"
}
```

Końcówka /production/dailyReport zwraca json w formacie:
```json
{
  "1": {
    "1": 0.451,
    "13": 0.701,
    "14": 0.331
  }
}
```

W została zaimplementowana metoda:
```
production($generatorId, $dateFrom, $dateTo)
```