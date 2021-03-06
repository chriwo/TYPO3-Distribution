#!/bin/bash
CURRENT_DIRECTORY="$( cd "$(dirname "$0")" ; pwd -P )"
BUILD_DIRECTORY="$( cd "$(dirname "$CURRENT_DIRECTORY")" ; pwd -P )"
PROJECT_DIRECTORY="$( cd "$(dirname "$BUILD_DIRECTORY")" ; pwd -P )"
DDEV_DIRECTORY="$PROJECT_DIRECTORY/.ddev/"

DATABASE_BACKUP_DIRECTORY="database"
DATABASE_BACKUP_PATH="$PROJECT_DIRECTORY/web/fileadmin/$DATABASE_BACKUP_DIRECTORY"
pushd "${PROJECT_DIRECTORY}"

# install dependencies
composer install -d /var/www/html

# add local development configuration
rm -f web/.htaccess && cp build/deployment/development-ddev/.htaccess web/.htaccess
rm -f web/typo3conf/AdditionalConfiguration.php && cp build/deployment/development-ddev/AdditionalConfiguration.php web/typo3conf/AdditionalConfiguration.php
rm -f web/typo3conf/realurl_conf.php

# copy realurl configuration if exist
if [ -f /var/www/html/build/deployment/development-ddev/realurl_conf.php ]
then
   cp build/deployment/development-ddev/realurl_conf.php web/typo3conf/realurl_conf.php
fi

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

if [ ! -d "$DATABASE_BACKUP_PATH" ]
then
  mkdir -p $DATABASE_BACKUP_PATH
fi

# active the next line, if you want to use typo3reversedeployment
#vendor/bin/typo3reverse reverse_full

echo "Import database dumps"
cat web/fileadmin/$DATABASE_BACKUP_DIRECTORY/*.sql | vendor/bin/typo3cms database:import
cat build/deployment/development-ddev/*.sql | vendor/bin/typo3cms database:import

rm -f web/fileadmin/$DATABASE_BACKUP_DIRECTORY/*

# add or change database after dump-import
vendor/bin/typo3cms database:updateschema "*.add,*.change"

# Remove all BE user to have no personal data (DSGVO)
echo "TRUNCATE TABLE be_users" | vendor/bin/typo3cms database:import

# Create be admin
echo "INSERT INTO be_users SET username=\"${TYPO3_ADMIN_USER}\", password = \"${TYPO3_ADMIN_PASSWORD}\", admin = 1" | vendor/bin/typo3cms database:import

# Finished cache
vendor/bin/typo3cms cache:flush

popd
