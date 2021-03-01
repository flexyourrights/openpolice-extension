
# FlexYourRights/OpenPoliceExtension

[![Laravel](https://img.shields.io/badge/Laravel-8.5-orange.svg?style=flat-square)](http://laravel.com)
[![Survloop](https://img.shields.io/badge/Survloop-0.3-orange.svg?style=flat-square)](https://github.com/rockhopsoft/survloop)
[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

# Table of Contents
* [About](#about)
* [Requirements](#requirements)
* [Getting Started](#getting-started)
* [Documentation](#documentation)
* [Roadmap](#roadmap)
* [Change Logs](#change-logs)
* [Contribution Guidelines](#contribution-guidelines)
* [Reporting a Security Vulnerability](#security-help)


# <a name="about"></a>About

This package provides a starting point to build variations of OpenPolice.org. Hopefully, you should be able to...
* Make a copy of this repository for your new project
* In you new project, replace all FlexYourRights\OpenPoliceExtension references with your package's primary class name, like MyVendorName\MyOpenPoliceProject"
* Replace all flexyourrights\openpolice-extension references with your package's directory, like my-org-name\my-open-police-project"
* 

<a href="https://openpolice.org" target="_blank">OpenPolice.org</a>
<a href="https://github.com/flexyourrights/openpolice" target="_blank">OpenPolice.org is an open-source, open data web app</a> empowering citizens to prepare, file, and track reports of police conduct. The site helps users submit complaints or commendations to appropriate police oversight agencies. By allowing users to publish reports online, we aim to establish better public transparency and oversight of police activity in the U.S. OpenPolice extends <a href="https://github.com/rockhopsoft/survloop" target="_blank">Survloop</a>, which runs atop <a href="https://laravel.com/" target="_blank">Laravel</a>.


# <a name="requirements"></a>Requirements

* php: >=7.4
* <a href="https://packagist.org/packages/laravel/laravel" target="_blank">laravel/laravel</a>: 8.5.*
* <a href="https://packagist.org/packages/rockhopsoft/survloop" target="_blank">rockhopsoft/survloop</a>: >=0.3.*
* <a href="https://packagist.org/packages/flexyourrights/openpolice" target="_blank">flexyourrights/openpolice</a>: >=0.3.*

# <a name="getting-started"></a>Getting Started

## Installing OpenPolice

<a href="https://openpolice.org/how-to-install-local-openpolice" target="_blank">Full install instructions</a> also describe how to set up a development environment using VirutalBox, Vargrant, and <a href="https://laravel.com/docs/8.x/homestead" target="_blank">Laravel's Homestead</a>. For these instructions, the new project directory is 'myopenpolice'.

### Install Laravel, Survloop, & OpenPolice on Homestead
```
% composer create-project laravel/laravel myopenpolice "8.5.*"
% cd myopenpolice

```

Edit these lines of the environment file to connect the default MYSQL database:
```
% nano .env
```
```
APP_NAME="My Open Police"
APP_URL=http://myopenpolice.local

DB_HOST=localhost
DB_PORT=33060
DB_CONNECTION=mysql
DB_DATABASE=myopenpolice
DB_USERNAME=homestead
DB_PASSWORD=secret
```

Next, install Laravel's out-of-the-box user authentication tools, Survloop, and the OpenPolice.org software:
```
% php artisan key:generate
% php artisan cache:clear
% COMPOSER_MEMORY_LIMIT=-1 composer require flexyourrights/openpolice-extension
% nano composer.json
```

From your Laravel installation's root directory, update `composer.json` to require and easily reference OpenPoliceExtension:
```
$ nano composer.json
```
```
...
"autoload": {
    ...
    "psr-4": {
        ...
        "FlexYourRights\\OpenPoliceExtension\\": "vendor/flexyourrights/openpolice-extension/src/",
        "FlexYourRights\\OpenPolice\\": "vendor/flexyourrights/openpolice/src/",
        "RockHopSoft\\Survloop\\": "vendor/rockhopsoft/survloop/src/",
    }
    ...
}, ...
```

Hopefully, editing `config/app.php` is no longer needed, but this can be tried if later steps break.
```
$ nano config/app.php
```
```
...
'providers' => [
    ...
    FlexYourRights\OpenPoliceExtension\OpenPoliceExtensionServiceProvider::class,
    FlexYourRights\OpenPolice\OpenPoliceServiceProvider::class,
    RockHopSoft\Survloop\SurvloopServiceProvider::class,
    ...
],
...
'aliases' => [
    ...
    'OpenPoliceExtension' => 'FlexYourRights\OpenPoliceExtension\OpenPoliceExtensionFacade',
    'OpenPolice' => 'FlexYourRights\OpenPolice\OpenPoliceFacade',
    'Survloop' => 'RockHopSoft\Survloop\SurvloopFacade',
    ...
], ...
```

If installing on a server, you might also need to fix some permissions before the following steps...
```
% chown -R www-data:33 storage database app/Models
```

Clear caches and publish the package migrations...
```
% php artisan config:clear
% php artisan route:clear
% php artisan view:clear
% echo "0" | php artisan vendor:publish --force
% composer dump-autoload
% curl http://myopenpolice.local/css-reload
```

With certain databases (like some managed by DigitalOcean), you may need to tweak the Laravel migration:
```
% nano database/migrations/2014_10_12_100000_create_password_resets_table.php
% nano database/migrations/2019_08_19_000000_create_failed_jobs_table.php
```
Add this line before the "Schema::create" line in each file:
```
\Illuminate\Support\Facades\DB::statement('SET SESSION sql_require_primary_key=0');
```

Then initialize the database:
```
$ php artisan migrate
$ php artisan db:seed --class=OpenPoliceSeeder
```
And if you want to import our list of United States police departments and zip codes:
```
$ php artisan db:seed --class=OpenPoliceDeptSeeder
$ php artisan db:seed --class=OpenPoliceDeptSeeder2
$ php artisan db:seed --class=OpenPoliceDeptSeeder3
$ php artisan db:seed --class=OpenPoliceDeptSeeder4
$ php artisan db:seed --class=ZipCodeSeeder
$ php artisan db:seed --class=ZipCodeSeeder2
$ php artisan db:seed --class=ZipCodeSeeder3
$ php artisan db:seed --class=ZipCodeSeeder4
```

### Initialize OpenPolice Installation

Then browsing to the home page should prompt you to create the first admin user account:<br />
http://myopenpolice.local

If everything looks janky, then manually load the style sheets, etc:<br />
http://myopenpolice.local/css-reload

After logging in as an admin, this link rebuilds many supporting files:<br />
http://myopenpolice.local/dashboard/settings?refresh=2


# <a name="documentation"></a>Documentation

Once installed, documentation of this system's database design can be found at /dashboard/db/all . This system's user experience design for data entry can be found at /dashboard/tree/map?all=1&alt=1 or publicly visible links like those above.

Better documentation is juuust beginning to be created...<br />
<a href="https://openpolice.org/code-package-files-folders-and-classes" target="_blank">openpolice.org/code-package-files-folders-and-classes</a>

More on the Survloop level is also starting here: <br />
<a href="https://survloop.org/package-files-folders-classes" target="_blank">survloop.org/package-files-folders-classes</a>.

# <a name="roadmap"></a>Roadmap

Here's the TODO list for the next release (**1.0**). It's my first time building on Laravel, or GitHub. So sorry.

* [ ] Correct all issues needed for minimum viable product, and launch Open Police Complaints.
* [ ] Integrate options for MFA using Laravel-compatible package.
* [ ] Code commenting, learning and adopting more community norms.
* [ ] Add decent levels of unit testing. Hopefully improve the organization of objects/classes.


# <a name="contribution-guidelines"></a>Contribution Guidelines

Please help educate me on best practices for sharing code in this community. Please report any issue you find in the issues page.

# <a name="security-help"></a>Reporting a Security Vulnerability

We want to ensure that Open Police Complaints is a secure HTTP open data platform for everyone. If you've discovered a security vulnerability in OpenPolice.org, we appreciate your help in disclosing it to us in a responsible manner.

Publicly disclosing a vulnerability can put the entire community at risk. If you've discovered a security concern, please email us at rockhoppers *at* runbox.com. We'll work with you to make sure that we understand the scope of the issue, and that we fully address your concern. We consider correspondence sent to rockhoppers *at* runbox.com our highest priority, and work to address any issues that arise as quickly as possible.

After a security vulnerability has been corrected, a release will be deployed as soon as possible.
