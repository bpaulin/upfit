#!bin/bash

./node_modules/.bin/phantomjs --webdriver=8643 > /dev/null 2>&1 &
echo $!
