Technical Information.
-----------------------------------------------------------------

Folders (in public_html):
:::::::::::::::::::::::::

controller:
php scrips to render web-pages or form action
Example:
register.php - renders register web-page
register_action.php - form action for register web-page.

helper:
php scripts with general purpose functions, message strings, etc...

misc:
php scripts and resources which will be used only during development.

template:
all twig templates.

assets:
all styles(css), images and other project resources.

cache:
will be used in deployed application for twig templates cache.

--------------------------------------------------------------------
Other folders:
::::::::::::::

documentation:
PHPStorm project specific documentation.

generated-classes:
propel generated content.
Contains folders:
Base, Map and classes generated from schema.xml.
Folders Base and Map should not be edited since all changes will be overwritten
by propel every time we run
vendor\propel\propel\bin\propel model:build.
And this should be done on every change of schema.xml
Classes in generated-classes like User.php, Task.php and so on can be
edited to extend functionality.

generated-sql:
propel generated content. Should not be edited since it can be overwritten
every time database schema changes.
to change/update use:
vendor\propel\propel\bin\propel sql:build
To update database (stud_v17_gruppe1) accordingly use:
vendor\propel\propel\bin\propel sql:insert

generated-conf:
propel generated content. Should not be edited since it can be overwritten
every time database connection changes.
to change/update:
edit propel.yaml file and run
vendor\propel\propel\bin\propel config:convert

vendor:
additional libraries we are using for project.

-------------------------------------------------------------------------------
Files:
::::::

schema.xml:
Our database file. Should only be edited by SQL responsible.

composer.json:
All additional libraries for our project.
usage: Right click->Add dependencies/Init composer.

composer.phar:
Composer install file. If you have occasionally deleted it,
just right click composer.json->init composer.

composer.lock:
Composer uses this file. Should not be edited.

propel.yaml:
Database connection setup for propel.

Readme.txt, propel.log - can be deleted.