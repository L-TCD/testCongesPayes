# bilemo

## Getting Started with Docker Compose

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up -d`
4. Open your app Symfony: `http://127.0.0.1:8741/`
Open phpMyAdmin: `http://127.0.0.1:8080/` (user:root and no password)
Open MailDev: `http://127.0.0.1:8081/`
5. Run `docker-compose down --remove-orphans` to stop the Docker containers.

## Create Database

```bash
docker exec -it www_docker_symfony bash
cd project
```