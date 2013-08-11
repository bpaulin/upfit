#!bin/bash

php app/console server:run > /dev/null &
echo $!
