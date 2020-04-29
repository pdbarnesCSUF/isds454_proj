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
INSERT INTO priority (priority_value,priority_name) VALUES (1,'High');
INSERT INTO priority (priority_value,priority_name) VALUES (2,'Medium');
INSERT INTO priority (priority_value,priority_name) VALUES (3,'Low');
INSERT INTO urgency (urgency_value,urgency_name) VALUES (1,'ASAP');
INSERT INTO urgency (urgency_value,urgency_name) VALUES (2,'Soon');
INSERT INTO urgency (urgency_value,urgency_name) VALUES (3,'Not Urgent');
INSERT INTO impact (impact_value,impact_name) VALUES (1,'Critical');
INSERT INTO impact (impact_value,impact_name) VALUES (2,'High');
INSERT INTO impact (impact_value,impact_name) VALUES (3,'Medium');
INSERT INTO impact (impact_value,impact_name) VALUES (4,'Low');
INSERT INTO category (category_name,category_description) VALUES ('General','non-specific');
INSERT INTO category (category_name,category_description) VALUES ('Hardware','hardware issues');
INSERT INTO category (category_name,category_description) VALUES ('Software','software issues');
INSERT INTO category (category_name,category_description) VALUES ('Networking','networking issues');
INSERT INTO category (category_name,category_description) VALUES ('Installation','installation of new equipment');
INSERT INTO status (status_name) VALUES ('Complete');
INSERT INTO status (status_name) VALUES ('On Hold');
INSERT INTO status (status_name) VALUES ('New');
INSERT INTO status (status_name) VALUES ('In Progress');
INSERT INTO tier (tier_value,tier_name,tier_description) VALUES (1,'Tech Engineer','can handle everything');
INSERT INTO tier (tier_value,tier_name,tier_description) VALUES (2,'Help Desk','first help');

INSERT INTO users (user_firstname,user_lastname,user_email,user_department) VALUES ('John','Doe','jdoe@company.com','Accounting');
INSERT INTO support_agent (tier_id,agent_firstname,agent_lastname,agent_email) VALUES (1,'Edgar','Hoover','eh@company.com');
INSERT INTO support_agent (tier_id,agent_firstname,agent_lastname,agent_email) VALUES (2,'Frank','Abagnale','fa@company.com');

INSERT INTO ticket (ticket_title,ticket_date,ticket_comment,
                    user_id,category_id,status_id,
                    tier_id,priority_id,urgency_id,impact_id,agent_id           
                    ) VALUES (
                        'Need New Server','2015-10-25 19:32:56.78-07','Need new server for border',
                        1,5,2,
                        1,2,2,2,1);
                        
INSERT INTO ticket (ticket_title,ticket_date,ticket_comment,
                    user_id,category_id,status_id,
                    tier_id,priority_id,urgency_id,impact_id,agent_id           
                    ) VALUES (
                        'Broken Screen','2019-12-21 17:18:56.22-07','My screen looks strange',
                        1,2,4,
                        2,1,1,1,2);
                        
INSERT INTO ticket (ticket_title,ticket_date,ticket_comment,
                    user_id,category_id,status_id,
                    tier_id,priority_id,urgency_id,impact_id,agent_id           
                    ) VALUES (
                        'Help with installation','2020-03-22 12:34:56.78-07','plz install my scanner',
                        1,5,3,
                        2,NULL,NULL,NULL,NULL);

INSERT INTO ticket (ticket_title,ticket_date,ticket_comment,
                    user_id,category_id,status_id,
                    tier_id,priority_id,urgency_id,impact_id,agent_id           
                    ) VALUES (
                        'How to screenshot','2020-03-29 14:34:56.78-07','How do i take a screenshot',
                        1,1,3,
                        2,NULL,NULL,NULL,NULL);