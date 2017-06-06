Optibet API code test
========================

Code test written in PHP using Symfony3 framework.

Setup guide
--------------

1. Download Git repository

```
    git clone https://github.com/KMTests/OptibetApiTest.git
    cd OptibetApiTest
```

2. Build and start docker containers

```
    docker-compose up --build -d
```

3. Install dependencies and set up database

```
    docker-compose exec fpm sh ./bootstrap.sh
```

4. Run tests to make sure everything works correctly

```
    docker-compose exec fpm vendor/bin/behat
```

Usage
--------------
All API endpoints starts with http://localhost:8086/api/v1/

Request should contain header "Content-type: application/json"

Available resources:
    
**_GET /balance_**

Example request
```
    GET /balance?playerId=P1
```

Example response
```
    {
        "playerId": "P1",
        "balance": 99999999
    }
```

_**GET /fund**_

Example request
```
    GET /fund?playerId=P1&points=1000
```

Example response
```
    201 - EMPTY RESPONSE
```

_**GET /take**_

Example request
```
    GET /take?playerId=P1&points=300
```

Example response
```
    201 - EMPTY RESPONSE
```

_**GET /announceTournament**_

Example request
```
    GET /announceTournament?tournamentId=1&deposit=1000
```

Example response
```
    201 - EMPTY RESPONSE
```

_**GET /joinTournament**_

Example request
```
    GET /joinTournament?tournamentId=1&playerId=P1&backerId=P2&backerId=P3
```

Example response
```
    201 - EMPTY RESPONSE
```

_**POST /resultTournament**_

Example request
```
    POST /resultTournament
```

Example response
```
    201 - EMPTY RESPONSE
```
    