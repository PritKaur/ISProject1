#!/bin/bash
mysqldump isproject1 | gzip > /var/backups/isproject1/db_$(date +%F).sql.gz
