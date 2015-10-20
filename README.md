NitroXy - INFO
===================================================

## Prerequisites

Vad du behöver göra innan installation

* LAMP-stack
* [Composer](https://getcomposer.org/)
* [Compass](http://compass-style.org/)
* API nyckel från [NitroXy](https://nitroxy.com) (prata med Admin)

## Installationsguide

* `git clone https://github.com/NitroXy/nfo.git`
* Skapa MySQL databas och användare.
* `cp config.php{.sample,}`
* `cp nxauth.php{.sample,}`
* Konfigurera `config.php`
* Konfigurera `nxauth.php` (be någon om hjälp, det är lite krånligt och odokumenterat).
* `git submodules init` och `git submodules update`
* `composer install` (kräver att du installerat composer redan)
* `php migrations/update_migrations.php`
* `compass compile`
* Gå till sidan och välj "Logga in" nere i footern.  
Se till att du har rätt behörighet från nitroxy.com (prata med HA eller Admin om du tycker att du borde ha behörighet men saknar).

## Utveckling

* `compass watch`
