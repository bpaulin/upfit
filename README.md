Upfit
=====

[![Build Status](https://travis-ci.org/bpaulin/upfit.png?branch=master)](https://travis-ci.org/bpaulin/upfit)

## using phing, (included in composer.json)

    ./bin/phing [target]

### Default target:

    run:ci            continuous integration

### Main targets:

    base:dev:reset    reset dev database
    base:prod:create  init prod database
    base:prod:dump    dump prod database
    base:prod:update  update prod database
    base:test:reset   reset testing database
    check             check code quality
    composer:deploy   install dependencies for prod
    composer:install  install dependencies
    composer:update   update dependencies
    fix:style         fix code style
    report            generate all reports
    run:assets        generate assets
    run:ci            continuous integration
    run:demo          behat tests (all executed with selenium)
    run:deploy        magical (?!) deploy command
    test              run all tests
    test:behat        behat tests
    test:behat:wip    behat tests (only marqued as '@wip')
    test:unit         unit tests

### Subtargets:

    base:dev:create
    base:dev:drop
    base:dev:fill
    base:dev:update
    base:test:create
    base:test:drop
    base:test:fill
    base:test:update
    cache:clear:test
    check:cpd
    check:deps
    check:doc
    check:mess
    check:style
    check:syntax
    check:syntax:php
    check:syntax:twig
    composer:self-update
    report:behat
    report:doc
    report:loc
    report:test
    test:base


