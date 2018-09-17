# UK Premier League

# Installing and running

Add an entry `127.0.0.1 footbal-teams.loc` to your `/etc/hosts` file:
```sh
sudo echo "127.0.0.1 footbal-teams.loc" >> /etc/hosts
```
Run from the following from the project root:
```
docker-compose build
docker-compose up -d
docker exec -it footbal_teams_php bash -c "composer install"
```

You can now verify the webserver is running with
```
curl footbal-teams.loc:8001 -vvv
```
and tests can be run with 
```
docker exec -it footbal_teams_php bash -c "vendor/bin/phpunit"
```
