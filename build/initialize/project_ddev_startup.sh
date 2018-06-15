#! /bin/bash

# set ssh keys
/var/www/html/build/initialize/project_ddev_ssh.sh

if [ -e /tmp/initialized ]
then
    echo "Already initialized"
else
    echo "Initializing"
    /var/www/html/build/initialize/project_ddev_initialize.sh
    touch /tmp/initialized
fi
