#######################################################################
# ⚠️🔥🚧 Warning! These commands are for local development only 🚧🔥⚠️
#######################################################################

# Variables
DOCKER_COMPOSE = docker-compose

# Check if .env file exists
check_env_file := $(shell if [ -f .env ]; then echo "true"; fi)

# ANSI escape codes for color formatting
RED := \033[0;31m
NC := \033[0m

# Build Docker images
build:
	@echo "Building docker images..."
	$(DOCKER_COMPOSE) build

# Start Docker containers
start:
ifeq ($(check_env_file),true)
	@echo "$(RED)WARNING: The .env file exists! The .env file takes precedence over system environment variables for Laravel, which may override settings specified in the docker-compose.yml file.$(NC)" >&2
	@read -p "Do you want to continue? [y/N] " continue; \
    	if [ "$$continue" != "y" ] && [ "$$continue" != "Y" ]; then \
    		echo "Aborted."; \
    		exit 1; \
    	fi
endif
	@echo "Starting docker containers..."
	$(DOCKER_COMPOSE) up -d

# Stop Docker containers
stop:
	@echo "Stopping docker containers..."
	$(DOCKER_COMPOSE) stop

# Remove Docker containers, volumes, and networks
remove:
	@echo "Removing docker containers, volumes, networks..."
	$(DOCKER_COMPOSE) down -v

# Initialize project
init:
	@echo "Coping .env ..."
	@docker exec -it php-fpm cp .env.example .env
	@echo "Setup cron"
	@docker exec -i php-fpm sh -c "echo '* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1' >> /etc/crontabs/root"
	@docker exec -it php-fpm crontab -l
	@echo "Installing composer packages..."
	@docker exec -it php-fpm composer install
	@echo "Installing orchid..."
	@docker exec -it php-fpm php artisan orchid:install
	@echo "Generate application key..."
	@docker exec -it php-fpm php artisan key:generate
	@echo "Installing npm packages..."
	@docker exec -it php-fpm npm install
	@echo "Building..."
	@docker exec -it php-fpm npm run production


# Run PHP container's shell
php_sh:
	@echo "Running PHP container's shell..."
	@docker exec -it php-fpm sh
