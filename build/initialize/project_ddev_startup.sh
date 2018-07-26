#!/bin/bash

if [ ! -e /var/www/html/build/initialized ]
then
    echo -e "\033[1;33m -- Initializing -- \033[0m"
    touch /var/www/html/build/initialized
    /var/www/html/build/initialize/project_ddev_initialize.sh
else
    echo -e "\033[32m -- Nothing to do, all is fine and ready -- \033[0m"
fi
