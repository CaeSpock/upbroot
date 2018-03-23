#!/bin/sh
echo Generating backup of the database
mysqldump -u'DBUSER' -p'DBPASS' --complete-insert=true --extended-insert=false DBNAME > /your/full/path/here/file.sql
