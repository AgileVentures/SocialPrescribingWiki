(This is a guide to creating the monthly moderation and marketing report for the NHS HLP Social Prescribing and Self-care wiki)


# Moderation

1. **List the number of rejected contributions with reasons**

Visit https://wiki.healthylondon.org and visit https://wiki.healthylondon.org/Special:Moderation (Note this requires mode)

Since we've added the ConfirmEdit captcha on signups you'll likely see the following:

![](images/Screenshot%202017-08-11%2013.40.17.png)

If you swich to rejected and mouse over any of the times you can see the dates of the most recent rejections:

![](images/Screenshot%202017-08-11%2013.46.31.png)

If the dates of any are in the current month (of the report) then they can be included in the number of rejected contributions. The `[No longer a spammer]` shows that the rejection was a spam submission.  Check with the moderator ([Sam Joseph](https://github.com/tansaku)) for any where the reason for rejection is unclear.

Examples:

> 0 rejected submissions.

OR

> 154 rejected submissions of which all were "spam" (irrelevant) submissions.

2. **Capacity required for moderation and time spent**

In order to describe the time spent on moderation there's no alternative at the moment to checking with the moderator ([Sam Joseph](https://github.com/tansaku) - we need to look at some way of automating this - perhaps some improvements to the moderation tool so that each approved edit gets logged with a reason ...

Examples:

> 0 This month we added the ConfirmEdit plugin and set it to display a "captcha" on the create account page, preventing non-human automated signups.  As a result there were no spam signups or submissions this month.   This has allowed admin time to be refocused on other improvements and ensuring the effective operation of the moderation of new human users. This month have spent less than an hour moderating incoming submissions and reviewing updates from auto-moderated members

OR

> In this second month the 154 "spam" submissions were again all very clearly irrelevant to the site, i.e. submissions on topics completely unrelated to healthcare. The moderation was largely handled by the automated system. Admins spent at most a couple of hours reviewing submissions, rejecting "spam" submissions and marking spammers as such. The authors of sensible submissions were quickly marked as moderator approved (requiring no more than a couple of hours over the month), and as such there were no on-topic submissions that needed to be rejected, and few that required moderation approval.

3. **Any issues with the process and practice of moderation?**

Again there's no immediate alternative at the moment apart from checking with the moderator ([Sam Joseph](https://github.com/tansaku).  Perhaps some general logging tool might be useful here.

Examples: 

> As the number of spam submissions increased we added the ConfirmEdit plugin and set it to display a “captcha” on the create account page.  That went live around June 21st, and so far has completely eliminated spam submissions.  Existing users have been able to continue to submit as normal and several new users have signed up, implying that the plugin is working as expected (it was of course thoroughly tested before deployment, but there is nothing like the real world as an acid test).  This plugin has saved a good hour or two a month as the admins no longer have to review the 100 or 200 or so spam submissions for the possibility that there is a single sensible submission among them.  Admin time can thus be refocused on other improvements and ensuring the effective operation of the moderation of new human users.

OR

> It appears that the new "captcha" has completely eliminated spam submissions to the site. As a consequence some other issues have been amplified. No notification appeared for one suggested change by a new user; only a notification when a new user was created.  The new user submission has been approved, but it is unclear how long the user had to wait for approval. For next month AgileVentures will check that moderation notifications are in place accordingly, to ensure speedy approval of relevant submissions. 

4. **Other data as agreed to aid evaluation**

No other data has yet been requested and so the standard entry here is:

> No other data yet requested.

5. **The number of user log-ins (unique and repeated)**

This data comes from [Google Analytics](https://analytics.google.com), and requires access to the HLP Wiki reports.  One needs to be careful to start off by navigating to "Audience" -> "Overview" and setting the date range appropriately:

![](images/Screenshot%202017-08-11%2014.11.04.png)

Here we'll see overview data for the month:

![](images/Screenshot%202017-08-11%2014.12.25.png)

At the moment we report the number of visits to the site (sessions), the number of different unique users (users), the average session duration (Avg. session duration) and the average number of pages visited (Pages/Session).

Examples:

> Logins are not required to view the site. Site traffic from Google Analytics indicates that over the last month there were 261 visits to the site, corresponding to 149 different unique users. The average session duration was 3 minutes and 28 second s which involved visiting on average 4.28 pages.  These numbers are all similar to the previous month.

OR

> Logins are not required to view the site. Site traffic from Google Analytics indicates that over the last month there were 238 visits to the site, corresponding to 139 different unique users. The average session duration was 2 minutes and 54 seconds which involved visiting on average 2.95 pages.  These numbers are all down slightly on the previous month.

# Marketing

1. **Number of users that logged in who commented or added to the wiki**

This involves navigating to https://wiki.healthylondon.org/Special:ActiveUsers where we'll see output like the following:

![](images/Screenshot%202017-08-11%2014.21.11.png)

Which we can turn into a report with a table like so

Examples:

> 4 users were active in the last 30 days (down from 11 last month)

> | #Actions | UserName       |
> | ---------|----------------|
> | 49       | Suzi.griffiths |
> | 3        | JacquiWheeler  |
> | 2        | Msekeram       |
> | 1        | BJBrown        |

2. **What sections of the resource receive the most activity from users?**

_Top ten visited pages:_

Here we usually include a screenshot from Google Analytics:

(Analytics —> Behaviour -> Site Contents —> All Pages [Pie Chart View])

Example: 

> ![](images/Screenshot%202017-08-11%2014.39.29.png)

_Top ten edited pages_

Here we grab data from https://wiki.healthylondon.org/Special:MostRevisions, where we'll see data like so:

![](images/Screenshot%202017-08-11%2014.42.48.png)

Note that this data is over the lifetime of the wiki rather than the last month per se.  It's not immediately clear how we could get a data view of this month by month - it would require further exploration of mediawiki or additional of some plugin.  Still it gives a lifetime overview of the total edits on all pages.

Example:

> | #Revisions | Page Name                                                           |
> | -----------|---------------------------------------------------------------------|
> | 61         | Social Prescribing and Self Care Wiki                               |
> | 25         | Social Prescribing                                                  |
> | 14         | Help                                                                | 
> | 14         | Policy and strategy in social prescribing                           |
> | 14         | Test Page                                                           |
> | 11         | Social prescribing for children, young people, parents and carers   |
> | 11         | Steps towards implementation                                        |
> | 10         | Monitoring and evaluating social prescribing                        | 
> | 10         | Digital engagement                                                  |
> | 9          | Social prescribing and mental health                                | 


3. **Geographical location and role of user**

Here we usually include a screenshot from Google Analytics:

_Breakdown by Country_

(Analytics —> Audience -> Geo —> Location [Pie chart view] by country)

Example:

> ![](images/Screenshot%202017-08-11%2014.59.41.png)

_Breakdown by City_

(Analytics —> Audience -> Geo —> Location [Pie chart view] by city)

Example:

> ![](images/Screenshot%202017-08-11%2015.01.14.png)

_Breakdown by Demographic_

(Analytics —> Audience -> Demographics —> Overview)

Example:

> ![](images/Screenshot%202017-08-11%2015.04.32.png)

4. **Information of promotion/marketing of the resource**

For this one would need to talk to the marketing team to check what activities have taken place this month.

Example:

> AgileVentures has ben investigating using some of their Google AdWords budget to help promote the wiki, but have come up against Google regulations which restrict the use of Google AdWords to promoting only the domains that were registered when the charity signed up for the Google AdWords grant.  As a result we cannot put AdWords behind sites that are not under the agileventures.org domain.  AgileVentures Co-Founder Sam Joseph attended the NW CCG meeting to promote the wiki to the commissioners, where the wiki was well received.


5. **Other data as agreed to assist evaluation (i.e.uptime/downtime)**

Azure guarantees a high level of uptime which is usually covered by the following statement:

> Azure guarantees a 99% uptime for their Azure service: https://azure.microsoft.com/en-us/support/legal/sla/cloud-services/v1_0/ - there have not been any outages in the last month.

although sometimes we'll need to add things like the following:

> This month we needed to take the site down for an hour to renew our https security certificates.

6. **Planned work going forward**

Here we need to include sections of work planned for the upcoming months e.g. 

> **August:**

> -  Script for help video
> -  Launch logo

> **September:**	
> -  Help video

> **October:**
> -  SEO push
