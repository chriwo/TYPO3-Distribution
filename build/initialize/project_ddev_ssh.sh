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