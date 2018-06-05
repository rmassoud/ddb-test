# Full Stack Lead Developer Test

### How do I get set up? ###

Create the parameters file
```bash
cp app/config/parameters.yml.dist app/config/parameters.yml
```

Run composer install to download required libraries.
```bash
composer install
```
Run dockerized containers
```bash
docker-compose up
```
Now access the app on [http://localhost:9090/](http://localhost:9090/)