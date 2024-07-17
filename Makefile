.PHONY: up down build restart logs sh php-bash migrate db-create db-migrate db-diff db-drop

# Démarrer les conteneurs
up:
	docker-compose up -d

# Arrêter les conteneurs
down:
	docker-compose down

# Construire les conteneurs
build:
	docker-compose up --build -d

# Redémarrer les conteneurs
restart:
	docker-compose down && docker-compose up -d

# Afficher les logs
logs:
	docker-compose logs -f

# Accéder au shell du conteneur PHP
sh:
	docker-compose exec php sh

# Accéder au bash du conteneur PHP
php-bash:
	docker-compose exec php bash

# Exécuter les migrations de la base de données
migration-create:
	docker-compose exec php php bin/console make:migration

# Créer la base de données
db-create:
	docker-compose exec php php bin/console doctrine:database:create --if-not-exists

# Créer les fichiers de migration
db-migrate:
	docker-compose exec php php bin/console doctrine:migrations:migrate

# Appliquer les migrations
db-migrate-diff:
	docker-compose exec php php bin/console doctrine:migrations:diff

# Supprimer la base de données
db-drop:
	docker-compose exec php php bin/console doctrine:database:drop --force

#exécuter composer install
composer-install:
	docker-compose exec php composer install 

# créer les fixtures
fixtures-create:
	docker-compose exec php php bin/console make:fixtures

# load fixtures
fixtures-load:
	docker-compose exec php php bin/console doctrine:fixtures:load

# Make entity
entity:
	docker-compose exec php php bin/console make:entity