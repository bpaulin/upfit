Upfit
=====

[![Build Status](https://travis-ci.org/bpaulin/upfit.png?branch=master)](https://travis-ci.org/bpaulin/upfit)

## using phing, (included in composer.json)

    ./bin/phing [target]

### Default target:

    check             check everything

### Main targets:

    asset:generate    generate assets
    base:dev:reset    reset dev database
    base:prod:create  init prod database
    base:prod:dump    dump prod database
    base:prod:update  update prod database
    base:test:reset   reset testing database
    check             check everything
    check:behat       behat tests
    check:behat:wip   behat tests (only marqued as '@wip')
    check:lint        check code syntax
    check:test        unit tests
    check:visual      behat tests (all executed with selenium)
    composer:deploy   install vendor for prod
    composer:install  install vendor
    composer:update   update vendor
    deploy:prod       magical (?!) deploy command
    fix:style         fix code style
    report            generate all reports

### Subtargets:

    base:dev:create
    base:dev:drop
    base:dev:fill
    base:dev:update
    base:test:create
    base:test:drop
    base:test:fill
    base:test:update
    check:common
    check:cpd
    check:doc
    check:headless
    check:lint:php
    check:lint:twig
    check:mess
    check:style
    check:wip
    composer:self-update
    report:behat
    report:cpd
    report:doc
    report:mess
    report:test
