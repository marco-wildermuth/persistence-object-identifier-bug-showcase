ifeq ($(DOCKER_MACHINE_NAME),)
  # Else assume we have docker locally
  DOCKER_IP := "127.0.0.1"
else
  $(shell export DOCKER_MACHINE_NAME)
  DOCKER_IP := $(shell docker-machine ip $(DOCKER_MACHINE_NAME))
endif

DEV_USER = www-data
DEV_WWW = www

# Syncs only relevant runtime files to docker. Use with ARGS=-n for dry run
docker-sync: scp-rsync-filter
	rsync $(ARGS) -O --filter='dir-merge /.rsync-filter-dev' --delete -c -av --exclude .git -e "ssh -p 1122" . $(DEV_USER)@$(DOCKER_IP):$(DEV_WWW)/

scp-rsync-filter:
	scp -q -P 1122 .rsync-filter $(DEV_USER)@$(DOCKER_IP):$(DEV_WWW)/

dev-ssh:
	ssh -A -p 1122 $(DEV_USER)@$(DOCKER_IP)
