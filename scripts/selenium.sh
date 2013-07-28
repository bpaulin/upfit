#!bin/bash

java -jar vendor/selenium/standalone-server/selenium-server-standalone-2.*.jar > /dev/null 2>&1 &
echo $!
