--an sql to clear all tables and reset filler info

--clear all tables
TRUNCATE    user,
            priority,
            urgency,
            impact,
            category,
            status,
            tier,
            support_agent,
            ticket;

--data insertion here....
