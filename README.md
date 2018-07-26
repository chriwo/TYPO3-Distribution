# TYPO3 Distribution

This is the base to start of new project. If you like local development and docker, so you can use [ddev][1] with this 
distribution. Only a little manuel step are need to start with the new project.

## 1. Requirement of your local machine

* Windows 10 Pro, macOs Sierra or higher, Linux
* [ddev][1] version 0.19.0 or higher
* [Git][2]

## 2. Preparations

1. Create an repository (e.g. on github, bitbucket, gitlab or what you like)
2. You need ssh access to the repository

## 3. Setup your project

1. `git clone git@github.com:chriwo/TYPO3-Distribution.git <project-name>`
2. Set an project name in `/.ddev/config.yaml` on line 2. **This name would be part of your local development URI**
3. Open your console (shell) and got to your project folder
4. Type `ddev start` to start ddev

#### 3.1 TYPO3 login data for local development

* Username: `admin`
* Password: `password`
* Install-Tool: `joh316`

#### 3.2 Little tips with ddev

* start local development with `ddev start`
* stop local development with `ddev stop`
* destory docker container with `ddev remove -R` (This command will destroy both the containers and the imported database contents.)
* for more information about ddev cli have a look into [Ddev - Using CLI][3]

#### 3.3 Using typo3reverse

[typo3reverse][4] is a project to get all data (database and files) from a remote server. If you have an existing project
setup the config-file under `/.reverse/`. And if you need an sync of database and file an ddev start, uncomment the line
30 in `/build/initialize/project_ddev_initialize.sh`. Now you could start you project with `ddev start` and typo3reverse
get all data from remote server.

## 4. Help supporting further development

How? There are multiple ways to support the further development

- **Patreon:** Support me on [patreon.com](https://www.patreon.com/chriwode).
- **Amazon Wishlist:** Satisfy a wish of my [Amazon wishlist](https://www.amazon.de/hz/wishlist/ls/9O32AGLF1OUS). 

[1]: https://ddev.readthedocs.io/en/latest/
[2]: https://git-scm.com/downloads
[3]: https://ddev.readthedocs.io/en/latest/users/cli-usage/
[4]: https://github.com/ochorocho/joro-typo3reversedeployment
