#!/bin/sh
echo Generating backup of the database
mysqldump -u'upbroot' -p'upb2018r00t!' --complete-insert=true --extended-insert=false upbroot > /home/upbroot/resources/upbroot.sql
