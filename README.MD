AJARCMS
=====

## Dépendances

Les dépendances sont toutes installez dans votre environnement docker : version de php, npm, gulp, mysql...etc

## Installation

### General
Adaptez votre `conf.inc.php` à la racine du projet et le `App/config/parameters.yml`

### Database
Renseignez vos identifiant dans `App/config/parameters.yml`
```
database:
    host: "percona-ajarcms"
    name: "ajarcms"
    port: "3306"
    user: "ajarcms"
    password: "ajarcms"
```

### GULP
```sh

npm install

gulp install

```