# hotshowers.org [![Travis](https://img.shields.io/travis/mihaeu/hotshowers.org.svg?maxAge=2592000)]() [![Coveralls](https://img.shields.io/coveralls/mihaeu/hotshowers.org.svg?maxAge=2592000)]() [![Gitter](https://img.shields.io/gitter/room/mihaeu/hotshowers.org.svg?maxAge=2592000&style=flat)](https://gitter.im/mihaeu/hotshowers.org) ![License MIT](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)

> A complete re-write of warmshowers.org.

## Why?

I love warmshowers.org, but I feel the technical choices made during development were made out of convenience, not because they were the right choices.

I would love to see more contributions to warmshowers.org, but was frustrated myself with having to learn out-dated frameworks, having very little documentation and pretty much nothing in the way of quality assurance.

## How?

 - PHP7 backend (which is pretty much only an API)
 - TypeScript/JavaScript frontend (all website related stuff, templating etc.)

## Features

 - [x] a user has a username, email, address, phone number, latitude and longitude  and password
 - [x] an address consists of a city, zip code, country, street and house number
 - [x] a user can find other users by username, name, email and city
 - [ ] a user can write messages to other users
 - [ ] a user can write a request to other users
 - [ ] a user has a profile
 - [ ] a user can reply to a message
 - [ ] a new user has to sign up

## Design Decisions

#### Immutability

All value objects have to be immutable. If a setter or `add` method is required, it shall return a new instance.

#### `__toString()` and `toString()` on value objects

All value objects have to implement `__toString()` and `toString()`. The implementation of `__toString()` shall call `toString()`. `__toString()` should never be called from the code (magic method). Instead use `toString()` for consistency with other scalar getters.

#### Exposing scalar values on value objects

Value objects which wrap a scalar value (e.g. `string` as the internal representation of `Username`) shall expose (i.e. only if necessary) them using a `toX()` method (e.g. `toString()`, `toInt()`, ...).

#### Type hints

Using type hints for return values and parameters is mandatory.

#### Git commit messages

Messages have to meet the following requirements:

1. Separate subject from body with a blank line
2. Limit the subject line to 50 characters
3. Capitalize the subject line
4. Do not end the subject line with a period
5. Use the imperative mood in the subject line
6. Wrap the body at 72 characters
7. Use the body to explain what and why vs. how

For more info check out Chris Beams excellent post on [How to write a Git Commit Message](http://chris.beams.io/posts/git-commit/)

## Code Quality

 - Line Coverage has to be at least 95%, but usually there shouldn't be any reason to drop below 100%
 - All tests have to add `@covers` and `@uses` annotations to the test class (not the methods)
 - Code has to pass PSR-2 style guidelines (see `style` task in the [Makefile](Makefile))
