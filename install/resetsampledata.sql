--an sql to clear all tables and reset filler info

--clear all tables
TRUNCATE    users,
            priority,
            urgency,
            impact,
            category,
            status,
            tier,
            support_agent,
            ticket
            RESTART IDENTITY; --restarts counters

--data insertion here....
