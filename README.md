# Ask Serialization

Library containing serializers and deserializers for the PHP implementation of the Ask query language.

[![Build Status](https://secure.travis-ci.org/wmde/AskSerialization.png?branch=master)](http://travis-ci.org/wmde/AskSerialization)
[![Coverage Status](https://coveralls.io/repos/wmde/AskSerialization/badge.png?branch=master)](https://coveralls.io/r/wmde/AskSerialization?branch=master)

On Packagist:
[![Latest Stable Version](https://poser.pugx.org/ask/serialization/version.png)](https://packagist.org/packages/ask/serialization)
[![Download count](https://poser.pugx.org/ask/serialization/d/total.png)](https://packagist.org/packages/ask/serialization)

## Requirements

* PHP 5.3 or later
* [Ask](https://github.com/wmde/Ask) 1.x or later
* [DataValues](https://www.mediawiki.org/wiki/Extension:DataValues) 0.1 or later
* [DataValuesCommon](https://www.mediawiki.org/wiki/Extension:DataValuesCommon) 0.1 or later
* [Serialization](https://github.com/wmde/Serialization/blob/master/README.md) 2.x

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `ask/serialization` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
Ask 1.0:

    {
        "require": {
            "ask/serialization": "1.0.*"
        }
    }

### Manual

Get the Ask Serialization code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the Ask Serialization library by including its entry point:
AskSerialization.php.

## Library structure

The Ask language objects can all be serialized to a generic format from which the objects can later
be reconstructed. This is done via a set of Serializers/Serializer implementing objects. These
objects turn for instance a Query object into a data structure containing only primitive types and
arrays. This data structure can thus be readily fed to json_enoce, serialize, or the like. The
process of reconstructing the objects from such a serialization is provided by objects implementing
the Deserializers/Deserializer interface.

Serializers can be obtained via an instance of SerializerFactory and deserializers can be obtained
via an instance of DeserializerFactory. You are not allowed to construct these serializers and
deserializers directly yourself or to have any kind of knowledge of them (ie type hinting). These
objects are internal to the Ask library and might change name or structure at any time. All you
are allowed to know when calling $serializerFactory->newQuerySerializer() is that you get back
an instance of Serializers\Serializer.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

Ask has been written by [Jeroen De Dauw](https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw)
as [Wikimedia Germany](https://wikimedia.de) employee for the [Wikidata project](https://wikidata.org/).

## Release notes

### 1.0 (dev)

Initial release with these features:

* Serializers for all implemented Ask language objects
* Deserializers for all implemented Ask language objects

## Links

* [Ask on Packagist](https://packagist.org/packages/ask/ask)
* [Ask on Ohloh](https://www.ohloh.net/p/ask)
* [TravisCI build status](https://travis-ci.org/wmde/Ask)
* [NodeJS implementation of Ask](https://github.com/JeroenDeDauw/AskJS)
