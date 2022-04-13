#### 🎵 🐳 The Symfony-docker Makefile 🐳 🎵
* make help - Outputs this help screen

#### Docker 🐳
* make build - Builds the Docker images
* make up - Start the docker hub in detached mode (no logs)
* make start - Build and start the containers
* make down - Stop the docker hub
* make logs - Show live logs
* make sh - Connect to the PHP FPM container

#### Composer 🧙
* make composer - Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
* make vendor - Install vendors according to the current composer.lock file

#### Symfony 🎵
* make sf - List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
* make cc - Clear the cache

#### PHP Unit 🧪
* make test - Run php unit you can pass parameter "c="
