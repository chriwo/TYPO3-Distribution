## TYPO3 Distribution

This is the base to start a new project and deploy it with [Surf](https://github.com/TYPO3/Surf) to your server. I will 
describe the manuel steps to initialize the new project. In a few versions I hope I could write a small shell script to 
automate this steps.

### Preparations

1. Create an repository (e.g. on github, bitbucket, gitlab or what you like)
2. You need ssh access to the repository
3. You need ssh access to the deployment server

### Usage this distribution

1. `git clone git@github.com:chriwo/TYPO3-Distribution.git <project-name>`
2. `cd <project-name>`
3. `rm -rf .git && git init && git add . && git commit -m "Initial commit after kickstart"`
4. `composer install`
5. `./typo3cms install:setup`
6. `./typo3cms configuration:remove DB`
7. `git add . && git commit -m "After Install"`
8. Set the database connection in the file(s) under /shared/conf/
9. Set own INSTALL TOOL password. The default is `joh316-kasper`
10. `ssh <server-alias> 'mkdir -p <path>/shared/conf && cd <path>/shared/Data && pwd'`
11. `scp /shared/conf/* <server-alias>:<path>/shared/conf`

### <a name="remoteDeploy"></a>Preparing for Surf to deploy on a remote server
1. `ssh <deploy-server-alias> 'mkdir -p ~/.surf/deployment && cd ~.surf/deployment && pwd'`
2. Edit the files under `build/deployment/ExampleConfigurationConfig.php`
3. `scp /build/deployment/ExampleDeploymentConfig.php <deploy-server-alias>:~/.surf/deployment/<CustomerName>.php`

#### Deploy with Surf
1. Log into your deployment server via SSH
2. Deploy with `DEPLOYMENT_SOURCE:tag=1.0.0 surf deploy <CustomerName>`

*You could also use the your deployment with `describe` or `simulate`instead of `deploy`*

### <a name="localDeploy"></a>Preparing for Surf to deploy from local
1. Edit the files under `build/deployment/ExampleDeploymentConfig.php`
2. `cp <local-path>/build/deployment/ExampleDeploymentConfig.php ~/.surf/deployment/<CustomerName>.php

#### Deploy with Surf
1. `DEPLOYMENT_SOURCE:tag=1.0.0 surf deploy <CustomerName>`

*You could also use the your deployment with `describe` or `simulate`instead of `deploy`*

### After first deploy

1. Create your on project package as TYPO3 extension under `web/typo3conf/ext/<project-package>`
2. In the gitignore file enable line 33 and rename `<your_site_package>` with your project package name and remove the `#`
3. `git add . && git commit -m'After creation of project package'`

### How to deploy to other server

Now your project is ready to deploy to an staging or production server you must repeat the steps for 
[deploy from remote server](#remoteDeploy) or [deploy from local machine](#localDeploy). Instated of `<CustomerName>` you
could use `CustomerNameProduction`.

### Thanks

This distribution and the installation script was inspired from [@helhum](https://twitter.com/helhum?lang=de), the author 
of the [TYPO3 Distribution](https://github.com/helhum/TYPO3-Distribution) and his 
[install gist](https://gist.github.com/helhum/6fa5401cae5ba553e1954b579e1dea5b).
