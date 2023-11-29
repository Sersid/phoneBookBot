docker-build:
	docker-compose up -d --build
docker-up:
	docker-compose up -d
docker-down:
	docker-compose down
docker-restart: docker-down docker-up
bash:
	docker-compose exec php-fpm bash
perm:
	sudo chown ${USER}:${USER} ./* -R
perm-migrations:
	sudo chown ${USER}:${USER} ./database/migrations/* -R
perm-logs:
	sudo chown ${USER}:${USER} ./storage/logs/* -R
