# WebIT - TERC 
Provides polish territorial entities based on GUS TERC file ([http://eteryt.stat.gov.pl](http://eteryt.stat.gov.pl))
Please note, this repository contains JUST sample data. Obtain real data from official GUS website.

## Installation

Install via `composer`

```bash
composer require webit/terc
```

## Usage

### Voivodeship

`VoivodeshipRepository` provides access to `Voivodeship` objects representing voivodeships in Poland (pol. "województwo").

```php
<?php
use Webit\Terc\VoivodeshipRepository;
use Webit\Terc\Voivodeship;
use Webit\Terc\VoivodeshipCode;

// check how to obtain an instance of repository in the Infrastructure section of this README.md
/** @var VoivodeshipRepository $repository */

/** @var Voivodeship $voivodeship */
$voivodeship = $repository->get(new VoivodeshipCode('02'));  // returns `Voivodeship`
echo $voivodeship->code() . "\n"; // shows `VoivodeshipCode` object
echo $voivodeship->name() . "\n"; // shows voivodeship's name
echo (string)$voivodeship . "\n"; // returns voivodeship's name

$voivodeship = $repository->getByName('dolnośląskie'); // returns `Voivodeship`

// getting all the voivodeships
foreach ($repository->getAll() as $province) {
    // do something
}
```

### District

`DistrictRepository` provides access to `District` objects representing districts in Poland (pol. "powiat").

```php
<?php

use Webit\Terc\DistrictCode;
use Webit\Terc\DistrictRepository;
use Webit\Terc\District;
use Webit\Terc\VoivodeshipCode;

// check how to obtain an instance of repository in the Infrastructure section of this README.md
/** @var DistrictRepository $repository */

/** @var District $district */
$district = $repository->get(new DistrictCode('02'));

echo $district->code() . "\n"; // shows `DistrictCode` object (4 digits code)
echo $district->name() . "\n"; // shows district name
echo $district->type() . "\n"; // shows district type
echo $district->code()->voivodeshipCode() . "\n"; // shows `VoivodeshipCode`
echo $district->code()->districtCode() . "\n"; // shows two digits district code
echo (string)$district . "\n"; // returns districts name

echo $repository->getByVoivodeshipAndName(new VoivodeshipCode('02'), 'dzierżoniowski'); // returns districts's name

// getting all the districts
$limitOffset = \Webit\Terc\LimitOffset::create(250, 0); // optional, 100, 0 by default
foreach ($repository->getAll($limitOffset) as $district) {
    // do something    
}

// getting all the districts of given voivodeship
foreach ($repository->getAllOfVoivodeship(new VoivodeshipCode('02')) as $district) {
    // do something
}
```

### Borough

`BoroughRepository` provides access to `Borough` objects representing boroughs in Poland (pol. "gmina").

```php
<?php

use Webit\Terc\DistrictCode;
use Webit\Terc\BoroughCode;
use Webit\Terc\BoroughRepository;
use Webit\Terc\Borough;
use Webit\Terc\VoivodeshipCode;

// check how to obtain an instance of repository in the Infrastructure section of this README.md
/** @var BoroughRepository $repository */

/** @var Borough $borough */
$borough = $repository->get(new BoroughCode('0201011'));

echo $borough->code() . "\n"; // shows `BoroughCode` object (7 digits code)
echo $borough->name() . "\n"; // shows borough name
echo $borough->code()->voivodeshipCode() . "\n"; // shows `VoivodeshipCode` object
echo $borough->code()->districtCode() . "\n"; // shows `DistrictCode` object
echo $borough->code()->boroughCode() . "\n"; // shows two digits borough code
echo $borough->code()->boroughType() . "\n"; // shows `BoroughType` object
echo (string)$borough . "\n"; // returns districts's name

$boroughs = $repository->getByDistrictAndName(new DistrictCode('0201'), 'Boleslawiec'); // returns `BoroughCollection`

// getting all the boroughs
$limitOffset = \Webit\Terc\LimitOffset::create(250, 0); // optional, 100, 0 by default
foreach ($repository->getAll($limitOffset) as $borough) {
    // do something
}

// getting all the boroughs of given voivodeship
$limitOffset = \Webit\Terc\LimitOffset::create(250, 0); // optional, 100, 0 by default
foreach ($repository->getAllOfVoivodeship(new VoivodeshipCode('02'), $limitOffset) as $boroughs) {
    // do something
}

// getting all the boroughs of given district
foreach ($repository->getAllOfDistrict(new DistrictCode('0201')) as $boroughs) {
    // do something
}
```

## Infrastructure

The library provides two infrastructure implementations:
 * `InMemory` - keeps all the entities in memory
 * `Doctrine` - based on Doctrine ORM

### InMemory Infrastructure

#### Voivodeship

```php
<?php
use Webit\Terc\Infrastructure\InMemory\VoivodeshipRepositoryBuilder;
use Webit\Terc\Infrastructure\TercFile;

$builder = VoivodeshipRepositoryBuilder::create();
$builder->setLazy(false); // if you want initialise repository on build, true by default
$builder->fromFile(TercFile::create('my_TERC_filename.csv')); // if you want to provide own TERC.csv file (using build-in be default)
$builder->setCacheDir('/cache/dir'); // sets cache to FilesystemCache of Doctrine with a given directory
$builder->setCache(new \Doctrine\Common\Cache\ArrayCache()); // sets preconfigured cache

$voivodeshipRepository = $builder->build();

```

#### District

```php
<?php
use Webit\Terc\Infrastructure\InMemory\DistrictRepositoryBuilder;
use Webit\Terc\Infrastructure\TercFile;

$builder = DistrictRepositoryBuilder::create();
$builder->setLazy(false); // if you want initialise repository on build, true by default
$builder->fromFile(TercFile::create('my_TERC_filename.csv')); // if you want to provide own TERC.csv file (using build-in be default)
$builder->setCacheDir('/cache/dir'); // sets cache to FilesystemCache of Doctrine with a given directory
$builder->setCache(new \Doctrine\Common\Cache\ArrayCache()); // sets preconfigured cache

$districtRepository = $builder->build();

```

#### Borough

```php
<?php
use Webit\Terc\Infrastructure\InMemory\BoroughRepositoryBuilder;
use Webit\Terc\Infrastructure\TercFile;

$builder = BoroughRepositoryBuilder::create();
$builder->setLazy(false); // if you want initialise repository on build, true by default
$builder->fromFile(TercFile::create('my_TERC_filename.csv')); // if you want to provide own TERC.csv file (using build-in be default)
$builder->setCacheDir('/cache/dir'); // sets cache to FilesystemCache of Doctrine with a given directory
$builder->setCache(new \Doctrine\Common\Cache\ArrayCache()); // sets preconfigured cache

$boroughRepository = $builder->build();

```

#### Updating TERC entities with a new file

If `InMemory` repositories are using cache, you should use `TercEntitiesInMemoryUpdater` in order to replace
current entities with ones from a new file.

```php
<?php
use Webit\Terc\Infrastructure\InMemory\TercEntitiesInMemoryUpdater;
use Webit\Terc\Infrastructure\TercEntityFromCsvLoader;
use Webit\Terc\Infrastructure\TercFile;
use Doctrine\Common\Cache\FilesystemCache;

$tercEntityLoader = new TercEntityFromCsvLoader(
    TercFile::create('new_TERC_file.csv'),
    $cache = new FilesystemCache('/cache/dir') // or any other used
);

$updater = new TercEntitiesInMemoryUpdater(
    $tercEntityLoader,
    $cache
);
$updater->update();
```

### Doctrine ORM Infrastructure

In order to use Doctrine Infrastructure you need to configure `EntityManager` and update database schema

```php
<?php
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Webit\Terc\Infrastructure\Doctrine\Mapping\Mapping;
use Doctrine\DBAL\DriverManager;

$configuration = new Configuration();
$configuration->setMetadataDriverImpl(Mapping::createDriver());
$configuration->setProxyDir(sys_get_temp_dir().substr(md5(time().mt_rand(0, 100000)), 0, 6));
$configuration->setProxyNamespace('DoctrineProxy\\');

$entityManager = EntityManager::create(
    DriverManager::getConnection(['url' => 'sqlite:///:memory:']),
    $configuration
);

```

#### Voivodeship

```php
<?php
use Webit\Terc\Infrastructure\Doctrine\Voivodeship;

/** @var Doctrine\ORM\EntityManager $entityManager */

$voivodeshipRepository = $entityManager->getRepository(Voivodeship::class);
```

#### District

```php
<?php
use Webit\Terc\Infrastructure\Doctrine\District;

/** @var Doctrine\ORM\EntityManager $entityManager */

$districtRepository = $entityManager->getRepository(District::class);
```

#### Borough
 
```php
<?php
use Webit\Terc\Infrastructure\Doctrine\Borough;

/** @var Doctrine\ORM\EntityManager $entityManager */

$boroughRepository = $entityManager->getRepository(Borough::class);
```
 
#### Updating TERC entities with a new file

```php
<?php
use Webit\Terc\Infrastructure\Doctrine\TercEntitiesDoctrineUpdater;
use Webit\Terc\Infrastructure\TercEntityFromCsvLoader;
use Webit\Terc\Infrastructure\TercFile;

/** @var Doctrine\ORM\EntityManager $entityManager */

$updater = new TercEntitiesDoctrineUpdater(
    $entityManager,
    new TercEntityFromCsvLoader(
        TercFile::create('new_TERC_file.csv')
    )
);

$updater->update();
```
 
## Tests
 
 ```bash
 docker-compose run --rm composer
 docker-compose run --rm phpunit
 ```
 