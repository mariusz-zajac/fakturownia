.DEFAULT_GOAL := help

.PHONY: help
help: ## Prints this help text
	@echo "Usage: make \033[32m<command>\033[0m\n"
	@echo "the following commands are available:\n"
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

.PHONY: build
build: ## Build the docker image
	@docker build --no-cache -t fakturownia-php:latest .

.PHONY: run
run: ## Start the docker container
	@docker run -it --rm --name fakturownia-php -v "$$PWD:/app" -w /app -u "$$(id -u):$$(id -g)" --add-host=host.docker.internal:host-gateway fakturownia-php:latest bash
