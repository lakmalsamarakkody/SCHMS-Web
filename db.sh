#!/usr/bin/env bash
timestamp=`date`
mysqldump -h localhost -u schms -padmin schms > db.sql
git add db.sql
git commit -m "BACKUP : $timestamp"
git push
