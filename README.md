Installation
============

1. Clone and cd to project dir
1. `docker-compose up` 
1. `make docker-init-project`
1. Put to `/etc/hosts`:
```
127.0.0.1 frontend.localhost
127.0.0.1 backend.localhost
```
1. Open http://frontend.localhost , http://backend.localhost 
1. Run `make docker-project-setup-users`
1. Login to the backend with
```
    admin
    admin
```

or (N is number 1-9)

```
    userN
    userM
```


Development
===========

Pretty much all helper commands for development are in the make file and one should stick to that practice.
Run `make help` to get an idea about the commands.