#! /bin/bash
INITIALIZE_DIRECTORY="$( cd "$(dirname "$0")" ; pwd -P )"
BUILD_DIRECTORY="$( cd "$(dirname "$INITIALIZE_DIRECTORY")" ; pwd -P )"
PROJECT_DIRECTORY="$( cd "$(dirname "$BUILD_DIRECTORY")" ; pwd -P )"

pushd ${PROJECT_DIRECTORY}

echo "Run gulp to build frontend"
gulp build

popd
