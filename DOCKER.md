Docker Development
==================

This project is already pre-configured for Docker Development.

### Configuration

Make sure your Github Username is available using the environment variable named
`GITHUB_USERNAME`. If not already set, use your local 

`vi ~/.bash_profile` and append the line:

```
export GITHUB_USERNAME=YOUR_GITHUB_USERNAME_HERE
```

### composer install

This step is optional (but recommended and will also speedup things).

Run a `composer install` locally and make sure there are no errors:

```bash
composer install --no-dev --ignore-platform-reqs
```

### First time run

#### Deployment key

Make sure to configure a (personal) deployment key, so the docker container can access the repository.

Do:

```bash
ssh-keygen -t rsa -f docker/deploy_rsa -C "$(whoami) $(basename $(pwd)) deploy key" -N ""
```

Setup this key in Github as a deployment key. This key is needed so the docker
container can access the repo on init.

**Note**: you can have multiple deployment keys, e.g. one for each development
environment. They should not be shared by e.g. team co-workers!

#### Docker Compose UP

```bash
docker-compose up -d
docker-compose logs -f web
```

.. wait 'till you see the line:

```
.. NOTICE: ready to handle connections
```

### Access the Web Container via SSH

```bash
ssh -p1122 www-data@dev.davshop.docker
```

OR

```bash
make dev-ssh
```
