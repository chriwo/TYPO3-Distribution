#!/bin/bash
CURRENT_DIRECTORY="$( cd "$(dirname "$0")" ; pwd -P )"
BUILD_DIRECTORY="$( cd "$(dirname "$CURRENT_DIRECTORY")" ; pwd -P )"
PROJECT_DIRECTORY="$( cd "$(dirname "$BUILD_DIRECTORY")" ; pwd -P )"
DDEV_DIRECTORY="$PROJECT_DIRECTORY/.ddev/"

pushd "${PROJECT_DIRECTORY}"

# handle SSH keys
rm -rf /home/.ssh
mkdir /home/.ssh

if [ -f /tmp/.ssh/ddev.pub ]
then
    cp -f /tmp/.ssh/{ddev,ddev.pub,known_hosts} /home/.ssh/
    mv /home/.ssh/ddev.pub /home/.ssh/id_rsa.pub && mv /home/.ssh/ddev /home/.ssh/id_rsa
else
    cp -f /tmp/.ssh/{id_rsa,id_rsa.pub,known_hosts} /home/.ssh/
fi
chmod 600 /home/.ssh/*

# install dependencies
composer install -d /var/www/html

# add local development configuration
rm -f conf && ln -s ./shared/conf conf
rm -f web/typo3conf/AdditionalConfiguration.php && cp build/deployment/development-ddev/AdditionalConfiguration.php web/typo3conf/AdditionalConfiguration.php

vendor/bin/typo3cms install:fixfolderstructure
vendor/bin/typo3cms install:generatepackagestates

# Wait for db to become available
until mysqladmin ping -h db > /dev/null 2>&1
do
    echo "Waiting 5sec for db to become available";
    sleep 5;
done

vendor/bin/typo3cms database:updateschema "*.add,*.change"
vendor/bin/typo3cms extension:setupactive

# Finished cache
vendor/bin/typo3cms cache:flush

popd
