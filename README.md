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

4. Run tests to make sure everything is works correctly

```
    docker-compose exec fpm vendor/bin/behat
```

Usage
--------------