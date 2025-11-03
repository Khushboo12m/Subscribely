Cron Timing Cheatsheet

Field meanings:
────────────────────────
* ─ every possible value
m ─ minute (0–59)
h ─ hour (0–23)
dom ─ day of month (1–31)
mon ─ month (1–12)
dow ─ day of week (0–6) (0 = Sunday)

Examples:
────────────────────────
* * * * *  → Every minute
0 * * * *  → Every hour
0 0 * * *  → Every day at midnight
0 0 * * 1  → Every Monday at midnight
*/5 * * * * → Every 5 minutes
0 */2 * * * → Every 2 hours
0 9 * * 1-5 → Weekdays at 9 AM
0 12 1 * * → On the 1st of every month at 12 PM

Quick Trick:
────────────────────────
Count left to right:
Minute → Hour → Day → Month → Weekday
Change only what you need!

Read like a sentence:
0 15 * * * = “At minute 0, hour 15 (3 PM), every day”


*    *    *    *    *
│    │    │    │    │
│    │    │    │    └─ Day of week (0–6) (Sunday=0)
│    │    │    └───── Month (1–12)
│    │    └────────── Day of month (1–31)
│    └─────────────── Hour (0–23)
└──────────────────── Minute (0–59)

