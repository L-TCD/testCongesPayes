# Test technique «congés payés»

## Getting Started with Docker Compose

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up -d`
4. Open your app: `http://127.0.0.1:8741/`
5. Open phpMyAdmin: `http://127.0.0.1:8080/` (user:root and no password)
6. Open MailDev: `http://127.0.0.1:8081/`
7. Run `docker-compose down --remove-orphans` to stop the Docker containers.

```bash
docker exec -it www_docker_symfony bash
cd project
```

## L'exercice

Objectifs: obtenir le nombre de congés payés acquis lors d’une période de travail

### Ce que nous possédons :

1. Une période de travail avec date de début et date de fin
2. Une collection d’interruption de travail
une interruption de travail possède une date de début, une date de fin et indique si oui ou non, elle interrompt l’acquisition
de congés payés

### Méthode de calcul:

Les congés sont distribués mois par mois au nombre de 25/12 jour ouvrés.
1. chaque mois entièrement travaillé le montant mensuel complet
2. chaque mois partiellement travaillé octroie un montant au prorata temporis calendaire (ex: la période se termine le 12
septembre, ce mois-ci octroie donc 12/30 du solde mensuel de congés)
Écrire un algorithme pour compter le nombre de congés acquis.
Vous pouvez supposez que vous avez à disposition tout objet/méthode de manipulation de calendrier (compter le
nombre de jours entre deux dates, évaluer l’intersection entre deux périodes, etc.)