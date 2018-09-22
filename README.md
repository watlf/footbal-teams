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
it install all dependencies and create data base with data
```
make container-build
```

## Let's start

It uses JWT auth, so you need to register a user for it, or you can use default credentials for get a JMT token
```html
username => johndoe
password => 12345678
```

```
$ curl -X POST -H "Content-Type: application/json" http://footbal-teams.loc:8001/register -d '{"username":"USER_NAME","password":"PASS"}';
```

Than you can get a JWT token:
```
$ curl -X POST -H "Content-Type: application/json" http://footbal-teams.loc:8001/login_check -d '{"username":"johndoe","password":"12345678"}';
```

And now you can finally get an access for secured route:

#### Get a list of football teams in a single league

```
curl -H "Authorization: Bearer [TOKEN]" http://footbal-teams.loc:8001/api/league/{id}/teams
```

#### Create a football team:

```
$ curl -H "Authorization: Bearer [TOKEN]" "Content-Type: application/json" -X POST http://footbal-teams.loc:8001/api/league/{id}/add-team -d '{"name":"Manchester United","strip":"some text"}';
```

#### Modify all attributes of a football team:

```
$ curl -H "Authorization: Bearer [TOKEN]" "Content-Type: application/json" -X PUT http://footbal-teams.loc:8001/api/edit-team/{id} -d '{"name":"Wolverhampton","strip":"some text"}';
```

#### Delete a football league:

```
$ curl -H "Authorization: Bearer [TOKEN]" "Content-Type: application/json" -X DELETE http://footbal-teams.loc:8001/api/league/{id}/delete;
```

## Tests can be run with

```
make test
```
