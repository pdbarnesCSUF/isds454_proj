--isds454 ticket system
--designed for postgresql
--opted to change all strings to text for ease / psql : https://stackoverflow.com/questions/4848964/postgresql-difference-between-text-and-varchar-character-varying

CREATE TABLE user {
    user_id                 serial      PRIMARY KEY,
    user_firstname          text        ,
    user_lastname           text        ,
    user_email              text        ,
    user_department         text        
};

CREATE TABLE priority {
    priority_id             serial      PRIMARY KEY,
    priority_value          integer     NOT NULL,   --needed for ordering/preserving id
    priority_name           text        NOT NULL
};

CREATE TABLE urgency {
    urgency_id              serial      PRIMARY KEY,
    urgency_value           integer     NOT NULL,   --needed for ordering/preserving id
    urgency_name            text        NOT NULL
};

CREATE TABLE impact {
    impact_id               serial      PRIMARY KEY,
    impact_value            integer     NOT NULL,   --needed for ordering/preserving id
    impact_name             text        NOT NULL
};

CREATE TABLE category {
    category_id             serial      PRIMARY KEY,
    category_name           text        NOT NULL,
    category_description    text        
};

CREATE TABLE status {
    status_id               serial      PRIMARY KEY,
    status_name             text        NOT NULL
    --status_description    text        
};

CREATE TABLE tier {
    tier_id                 serial      PRIMARY KEY,
    tier_name               text        NOT NULL,
    tier_value              integer     NOT NULL,
    tier_description        text        
};

--rename to agent?
CREATE TABLE support_agent {
    agent_id                serial      PRIMARY KEY,
    agent_tier              integer     NOT NULL REFERENCES tier(tier_id),
    agent_firstname         text        ,
    agent_lastname          text        ,
    agent_email             text        NOT NULL
};

CREATE TABLE ticket {
    ticket_id               serial      PRIMARY KEY,
    ticket_title            text        NOT NULL,
    ticket_date             timestamp with time zone    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ticket_comment          text        NOT NULL,   --in real sys, seperate comment table
    ticket_attachment       boolean     NOT NULL DEFAULT false, --not good to put binaries in DB, true? check filesystem : dont look
    ticket_timeworked       interval    NOT NULL DEFAULT 0,
    ticket_user             integer     REFERENCES user(user_id),
    ticket_category         integer     REFERENCES category(category_id),
    ticket_status           integer     REFERENCES status(status_id),
    ticket_tier             integer     REFERENCES tier(tier_id),
    ticket_priority         integer     REFERENCES priority(priority_id),
    ticket_urgency          integer     REFERENCES urgency(urgency_id),
    ticket_impact           integer     REFERENCES impact(impact_id),
    ticket_agent            integer     REFERENCES support_agent(agent_id)
};