# Remind me app
Step by step install remind me app locally

#### For first time only !
- from main folder : `cd src/`
- run `docker compose up -d`
- run `docker compose exec php bash`
- run `composer setup`
- run `php artisan migrate:fresh --seed `

#### From the second time onwards
- run `docker compose up -d`

#### Trigger Email (only for trigger email)
- add config email on .env
- run `docker compose exec php bash`
- run `php artisan queue:work --queue=high,default ` 

### API
- open `http://localhost:8081/api`


## Frontend
- Open `http://localhost:3000`
