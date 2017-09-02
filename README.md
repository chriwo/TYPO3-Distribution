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
12. `cd ./build/Deployment && composer install`
13. `git add . && git commit -m 'Deployment config'`
14. Edit the files under `build/Deployment/.surf/`
15. `cd build/Deployment`
16. `DEPLOYMENT_SOURCE=branch:master ./vendor/bin/surf deploy development`

### After first deploy

1. Create your on project package as TYPO3 extension under `web/typo3conf/ext/<project-package>`
2. In the gitignore file enable line 31 and rename `<your_site_package>` with your project package name
3. `git add . && git commit -m'After creation of project package'`

### How to deploy to other server

Now your project is ready to deploy it to an staging or production server you must repeat the steps 9 and 10, 14 and 15.
In step 15 you use `staging` or `production` instead of `development`.

### Thanks

This distribution and the installation script was inspired from [@helhum](https://twitter.com/helhum?lang=de), the author 
of the [TYPO3 Distribution](https://github.com/helhum/TYPO3-Distribution) and his 
[install gist](https://gist.github.com/helhum/6fa5401cae5ba553e1954b579e1dea5b).
