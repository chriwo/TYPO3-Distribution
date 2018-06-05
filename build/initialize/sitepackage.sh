#!/bin/bash
DUMMY_SITEPACKAGE="customer_sitepackage"
DUMMY_PROJECT_NAME="Customer"
DUMMY_SITEPACKAGE_PATH="./build/package/"
CURRENT_DIRECTORY="$( cd "$(dirname "$0")" ; pwd -P )"
PROJECT_DIRECTORY="$( cd "$(dirname "CURRENT_DIRECTORY")" ; pwd -P )"

read -p "Get your vendor name: " i_vendor
read -p "Copy customer sitepackage, get new Ext-Key: " i_extKey
read -p "Project name: " i_projectname

if [ "$i_extKey" != "" ]
then
   NEW_SITEPACKAGE_PATH="$PROJECT_DIRECTORY/web/typo3conf/ext/$i_extKey"

   mkdir $NEW_SITEPACKAGE_PATH
   cp -r $PROJECT_DIRECTORY/build/package/customer_sitepackage/ $NEW_SITEPACKAGE_PATH

   # replace extKey in files
   sed -i '' 's/'"$DUMMY_SITEPACKAGE"'/'"$i_extKey"'/g' $NEW_SITEPACKAGE_PATH/ext_emconf.php
   sed -i '' 's/'"$DUMMY_SITEPACKAGE"'/'"$i_extKey"'/g' $NEW_SITEPACKAGE_PATH/Configuration/TCA/Overrides/sys_template.php
   sed -i '' 's/'"$DUMMY_SITEPACKAGE"'/'"$i_extKey"'/g' $PROJECT_DIRECTORY/gulp/config.js

   # replace "Customer" in files with project name
   sed -i '' 's/'"$DUMMY_PROJECT_NAME"'/'"$i_projectname"'/g' $NEW_SITEPACKAGE_PATH/ext_emconf.php
   sed -i '' 's/'"$DUMMY_PROJECT_NAME"'/'"$i_projectname"'/g' $NEW_SITEPACKAGE_PATH/Configuration/TCA/Overrides/sys_template.php
   sed -i '' 's/'"$DUMMY_PROJECT_NAME"'/'"$i_projectname"'/g' $NEW_SITEPACKAGE_PATH/Readme.md
   sed -i '' 's/'"$DUMMY_PROJECT_NAME"'/'"$i_projectname"'/g' $PROJECT_DIRECTORY/shared/conf/development-ddev.php

   # add sitepackage to .gitignore
   echo -e "\n!/web/typo3conf/ext/$i_extKey" >> $PROJECT_DIRECTORY/.gitignore
   echo "ready"
fi
