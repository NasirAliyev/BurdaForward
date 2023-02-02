# Installation guide for Project

Firstly, you need to install required tools on local machine:

##### 1. git bash
* Git: https://git-scm.com/downloads

##### 2. docker
* Win/Mac: https://www.docker.com/products/docker-desktop
* Linux: https://docs.docker.com/install/linux/docker-ce/ubuntu/

##### 3. docker compose
* installation : https://docs.docker.com/compose/install/

## After installing all tools you can start.

**Clone files from giving repository.**

**Create new `.env` file from `env.example` and set environment variables**
_(You also can use default settings.)_

```
 APP_PORT - The port which you can reach outside of containers. By default it is 80.
```

**Open CMD/Terminal and run following command:** 
```
docker compose up -d
```

**Check all containers by the command:** 
```
docker compose ps
```

If every thing is okay you should see all containers status *Up* :
```
NAME                SERVICE             STATUS              PORTS
burda_main_1        main                running             9000/tcp
burda_nginx_1       nginx               running             0.0.0.0:80->80/tcp, :::80->80/tcp
```

**Now you should run installation dependencies from main container:**
```
docker compose exec main composer install
```

### We have finished installation :)
#### Now you can open the project from this link : http://localhost
Note: If you changed port from .env you have to use port after URL. Example (APP_PORT=88): http://localhost:88

## Configs
```
./config/

├── docker
│ ├── Dockerfile
│ └── nginx
│     └── default.conf
└── routes.yml
```
- Main Dockerfile based on `php:8.2-rc-fpm` image.
- Web server is running in docker containers and `NGINX` is used for proxying
- All application routes can be set and modified in `routes.yml`
- Docker compose file `docker-compose.yml` is located in root directory

## Code style checking:
```
docker compose exec main composer phpcs
```

## Code style fixing:
```
docker compose exec main composer phpcbf
```

## Tests

Run all tests from command :
```
docker compose exec composer test
```

Also, you can run Unit and Functional tests separately:
```
docker compose exec main composer unit-test
```

```
docker compose exec main composer functional-test
```

## Additional 

**Soft and tools :** 
```
 PHP version - 8.
 PHPcs - latest version with rules PSR-12 Coding Style.
 PHPUnit - 9.5.
 Nginx - Used for proxying request from local machine into conatiners.
```

**Implemented Best practices :** 
- Using template engine implemented dynamically, different template engines can be used.
- Used Layered architecture. See [more](https://www.baeldung.com/cs/layered-architecture). Location `./src` directory:
  ```
  ├── Core
  ├── Domain
  ├── Infrastructure
  └── Presentation
  ```

**Used packages :**

-  symfony/yaml 
-  symfony/http-foundation
-  twig/twig

