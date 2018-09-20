# UK Premier League

## How to get started
In order to make things easier, please use [Docker](https://docs.docker.com/engine/installation/) setup 
with [Docker Compose](https://docs.docker.com/compose/install/)

## Installing and running

Add an entry `127.0.0.1 footbal-teams.loc` to your `/etc/hosts` file:
```
sudo echo "127.0.0.1 footbal-teams.loc" >> /etc/hosts
```
Run from the following from the project root (it uses Makefile for run command):
```
make container-build
```

You can now verify the webserver is running with
```
curl footbal-teams.loc:8001 -vvv
```
and tests can be run with 
```
make tests
```
