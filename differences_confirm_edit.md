mediawiki-codesniffer bumped to v18.0.0 Apr 13 2018
https://phabricator.wikimedia.org/rECOE9d9e57d26b5918283e7b0568ccd972e469774eaf

changes to fancycaptcha Mar 22 2018
https://phabricator.wikimedia.org/rECOE32ff18b8e32f9064d186d3c0d8df1a7124fa81ca 

build: Updating jakub-onderka/php-parallel-lint to 1.0.0 Mar 9 2018
https://phabricator.wikimedia.org/rECOEd37b6f034b5534c48c8fc7e98720e569117735fc

build: Updating mediawiki/minus-x to 0.3.1 Feb 17 2018
https://phabricator.wikimedia.org/rECOE527fd861d05fc3904a707b1aac3db4de24b83897

```
Set phan-taint-check-plugin version in composer.json Feb 16 2018 

We cannot set this in the normal "require-dev" because the plugin
depends on exactly PHP 7.0, preventing running tests on any other PHP
version.

Instead, CI will read the version number out of the "extra" field to
figure out what version to install.
```
Add https://phabricator.wikimedia.org/rECOE47ebc8aee2213e1befe9182f37fc692e4bf1d098
https://github.com/wikimedia/phan-taint-check-plugin
https://www.mediawiki.org/wiki/Phan-taint-check-plugin

Removed deprecated position statements from resource loader module
https://phabricator.wikimedia.org/rECOE7e78e7ccaa286668146ff6ac60a3cff2b227a546
fancycaptcha changes Feb 4 2018

build: Update linters
https://phabricator.wikimedia.org/rECOE0bbc51cebfad330ac7961b9e98245e8da593aec9
fancycaptcha changes Feb 4 2018



