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
1. Run `docker-compose exec php ./yii user/reset-admin-password admin` to reset admin password to `admin`
1. Login to the backend with
```
    admin
    admin
```