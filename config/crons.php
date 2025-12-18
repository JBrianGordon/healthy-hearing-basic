<?php

/*
|--------------------------------------------------------------------------
| HEALTHY HEARING - PRODUCTION
|--------------------------------------------------------------------------
*/

// -- INTRA-DAY PROCESSES

// * * * * * /var/www/prod18/hh/app/scripts/queue_process.sh
* * * * *  cd /var/www/prod/current && bin/cake queue run -q
// */10 * * * * /var/www/prod18/hh/app/scripts/parse_crm_emails.sh
// */5 * * * * /var/www/prod18/hh/app/scripts/parse_voicemail.sh

// -- DAILY PROCESSES
// ----------------------------------------------------------------------------------------
// ----- | (DAILY - Early morning)
// ------- | 30 5 * * * /var/www/prod/hh/app/scripts/daily_shells.sh (RUNNING ON HHAPP4)
// -----------------------------------------------------------------
// ./cake call_sources importLeadscoreReports
// ./cake ca_calls exportDailyYhnCallData
// PAUSED - In ticket #15221 -- ./cake ca_calls clearOldOutboundCalls
// ./cake ca_calls importBlueprintAppts (RUNNING ON HHAPP4)
// ./cake reviews clear_spam
// ./cake locations endGracePeriods
// ./cake locations unfreezeListingTypes
// ./cake locations findExpiredFeatures
// ./cake locations findListingTypesForOticon
// ./cake locations findListingTypesForCqp
// ./cake locations updateReviewCounts
// ./cake content freezeContent
30 5 * * * cd /var/www/prod/current && bin/cake editorial freezeContent
// ?? -- GETTING RID OF THIS? -- ./cake util cache_permissions
// ?? -- HOW WILL WE REPORT ERRORS? -- ./cake mail sendCronEmail "Daily" $FILENAME

// 30 1 * * * cd /var/www/prod18/hh/app && ./cake locations updateMetricsCache
// REMOVED -- COUNTMETRICS WERE REMOVED IN https://redmine.healthyhearing.com/issues/17166

// ----- | (DAILY - Midnight/Night)
// ------- | 30 0 * * * /var/www/prod18/hh/app/scripts/midnight_shells.sh
// ----------------------------------------------------------------------
// ./cake content set_last_modified
// ./cake content publishContent
30 5 * * * cd /var/www/prod/current && bin/cake editorial publish Content
// ./cake wiki publishWiki
30 5 * * * cd /var/www/prod/current && bin/cake editorial publish Wikis
// ./cake corp publishCorp
30 5 * * * cd /var/www/prod/current && bin/cake editorial publish Corps
// ./scripts/regenerate_sitemap.sh
# Regenerate query caches for sitemaps
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_City && curl -s https://dev.hhcake.com/sitemap_City.xml > /dev/null
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_Clinic && curl -s https://dev.hhcake.com/sitemap_Clinic.xml > /dev/null
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_Content && curl -s https://dev.hhcake.com/sitemap_Content.xml > /dev/null
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_Corp && curl -s https://dev.hhcake.com/sitemap_Corp.xml > /dev/null
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_Help && curl -s https://dev.hhcake.com/sitemap_Help.xml > /dev/null
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_State && curl -s https://dev.hhcake.com/sitemap_State.xml > /dev/null
// REMOVED -- COUNTMETRICS REMOVED IN #17166 - // ./cake locations updateMetrics
// REMOVED -- COUNTMETRICS REMOVED IN #17166 - // ./cake locations updateMetricsCache
// ?? -- GETTING RID OF THIS? -- // ./cake util cache_permissions
// ?? -- HOW WILL WE REPORT ERRORS? -- // ./cake mail sendCronEmail "Nightly" $FILENAME

// -- WEEKLY PROCESSES
// ----------------------------------------------------------------------------------------
// ------- | 30 6 * * 0 /var/www/prod18/hh/app/scripts/weekly_shells.sh
// --------------------------------------------------------------------
// ./cake city addAndUpdateCities
// ./cake city addAndUpdateCitiesByRange
// ./cake city findInvalidCities
// ./cake locations findDuplicates 1
// ./cake locations cleanupProviders
// ?? -- GETTING RID OF THIS? -- ./cake util cache_permissions
// ?? -- HOW WILL WE REPORT ERRORS? -- ./cake mail sendCronEmail "Weekly" $FILENAME

// -- MONTHLY PROCESSES
// ----------------------------------------------------------------------------------------
// 0 13 5 * * /var/www/prod18/hh/app/scripts/premier_analytics_shell.sh

/*
|--------------------------------------------------------------------------
| DEV4 SERVER - DEV AND QA environments
|--------------------------------------------------------------------------
*/

// -- INTRA-DAY PROCESSES

// * * * * * /var/www/dev/hh/app/scripts/queue_process.sh
* * * * * cd /var/www/dev/current && bin/cake queue run -q
// * * * * * /var/www/ca-dev/hh/app/scripts/queue_process.sh
* * * * * cd /var/www/ca-dev/current && bin/cake queue run -q
// * * * * * /var/www/qa18/hh/app/scripts/queue_process.sh
* * * * * cd /var/www/qa/current && bin/cake queue run -q
// * * * * * /var/www/ca-qa18/hh/app/scripts/queue_process.sh
* * * * * cd /var/www/ca-qa/current && bin/cake queue run -q

/*
|--------------------------------------------------------------------------
| HEARING DIRECTORY - PRODUCTION
|--------------------------------------------------------------------------
*/

// -- INTRA-DAY PROCESSES

// */1 * * * * /var/www/prod18/hh/app/scripts/queue_process.sh
* * * * *  cd /var/www/prod/current && bin/cake queue run -q

// -- DAILY PROCESSES
// ----------------------------------------------------------------------------------------
// ----- | (DAILY - Early morning)
// ------- | 50 5 * * * /var/www/prod18/hh/app/scripts/daily_shells.sh
// -----------------------------------------------------------------
// ./cake call_sources importLeadscoreReports
// SKIPPED ON CA/HD - CALL ASSIST DISABLED - ./cake ca_calls exportDailyYhnCallData
// PAUSED - In ticket #15221 -- ./cake ca_calls clearOldOutboundCalls
// HH-ONLY ON HHAPP4 -./cake ca_calls importBlueprintAppts
// ./cake reviews clear_spam
// SKIPPED ON CA/HD - TIERING IS DISABLED - ./cake locations endGracePeriods
// SKIPPED ON CA/HD - TIERING IS DISABLED - ./cake locations unfreezeListingTypes
// SKIPPED ON CA/HD - TIERING IS DISABLED - ./cake locations findExpiredFeatures
// HH-ONLY ON HHAPP4 - ./cake locations findListingTypesForOticon
// HH-ONLY ON HHAPP4 - ./cake locations findListingTypesForCqp
// ./cake locations updateReviewCounts
// SKIPPED ON CA/HD - REPORTS ARE DISABLED - ./cake content freezeContent
// ?? -- GETTING RID OF THIS? -- ./cake util cache_permissions
// ?? -- HOW WILL WE REPORT ERRORS? -- ./cake mail sendCronEmail "Daily" $FILENAME

// ----- | (DAILY - Midnight/Night)
// ------- | 30 0 * * * /var/www/prod18/hh/app/scripts/midnight_shells.sh
// ----------------------------------------------------------------------
// SKIPPED ON CA/HD - REPORTS ARE DISABLED - ./cake content set_last_modified
// SKIPPED ON CA/HD - REPORTS ARE DISABLED - ./cake content publishContent
// ./cake wiki publishWiki
30 5 * * * cd /var/www/prod/current && bin/cake editorial publish Wikis
// SKIPPED ON CA/HD - NO CORP PAGES - ./cake corp publishCorp
// ./scripts/regenerate_sitemap.sh
# Regenerate query caches for sitemaps
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_City && curl -s https://dev.hhcake.com/sitemap_City.xml > /dev/null
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_Clinic && curl -s https://dev.hhcake.com/sitemap_Clinic.xml > /dev/null
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_Help && curl -s https://dev.hhcake.com/sitemap_Help.xml > /dev/null
30 0 * * * cd /var/www/prod/shared/tmp/cache/ && rm -f cake_sitemap_query_State && curl -s https://dev.hhcake.com/sitemap_State.xml > /dev/null
// REMOVED -- COUNTMETRICS REMOVED IN #17166 - // ./cake locations updateMetrics
// REMOVED -- COUNTMETRICS REMOVED IN #17166 - // ./cake locations updateMetricsCache
// ?? -- GETTING RID OF THIS? -- // ./cake util cache_permissions
// ?? -- HOW WILL WE REPORT ERRORS? -- // ./cake mail sendCronEmail "Nightly" $FILENAME

// -- WEEKLY PROCESSES
// ----------------------------------------------------------------------------------------
// ------- | 30 6 * * 0 /var/www/prod18/hh/app/scripts/weekly_shells.sh
// --------------------------------------------------------------------
// ./cake city addAndUpdateCities
// ./cake city addAndUpdateCitiesByRange
// ./cake city findInvalidCities
// ./cake locations findDuplicates 1
// ./cake locations cleanupProviders
// ?? -- GETTING RID OF THIS? -- ./cake util cache_permissions
// ?? -- HOW WILL WE REPORT ERRORS? -- ./cake mail sendCronEmail "Weekly" $FILENAME

/*
|--------------------------------------------------------------------------
| REDMINE SERVER
|--------------------------------------------------------------------------
*/

// -- INTRA-DAY PROCESSES

// */5 * * * * cd /var/www/hh && git remote update --prune
// */5 * * * * cd /var/www/hh-cake4x && git remote update --prune

/*
|--------------------------------------------------------------------------
| HHDB1 - DB BACKUP SERVER
|--------------------------------------------------------------------------
*/

// -- DAILY PROCESSES

// 00 2 * * * /root/perconadump_prod.sh
// 30 2 * * * /root/cadb_dump_prod.sh
// 0 12 * * * /root/redmine.sh > /tmp/redmine.txt // DOESN'T CURRENTLY WORK