# WHMCS DomainRegister tools
**Various WHMCS tools and scripts to make your life easier**

### [Check user data hook](https://github.com/DomainRegister/WHMCS/blob/master/checkuser.php)
A hook that checks user data, in order to prevent the user from registering or later editing his data using:
- fake or disposable email addresses (using https://www.mailcheck.ai/ free API service)
- special characters
- too long strings

Further details about are available in [DomainRegister's knowledgebase](https://domainregister.international/index.php/knowledgebase/696/Check-User-Data-for-Better-WHMCS-Security.html).

### [Logcleaner hook](https://github.com/DomainRegister/WHMCS/blob/master/logcleaner-hook.php)
A hook that performs various log garbage collection, done daily

This script runs daily, at a given hour you can define at your own in line 18, and removes from logs various unuseful stuff 
In line  19 to 23 you can find various examples of queries to purge different logs:
- whoislog: removes every record oldest than 3 days
- activitylog: removes "automated task starting", "Domain Sync Cron completed" and "Cron running" records oldest than 2 days

You can add further queries to clean other kind of logs, used by addon or registrar module (i.e. in rows 23 to 25 you have code examples to clean dns_manager2_log, useful only if
you're using the DNS Manager Addon module by Modulesgarden.

You can customize the number of days any kind of record is retained before deleting it (  strtotime('-2 days'),  strtotime('-3 days') , strtotime('-5 days') etc.)

Further details about are available in [DomainRegister's knowledgebase](https://domainregister.international/index.php/knowledgebase/667/WHMCS---Automated-Log-Cleaning-Hook.html).

