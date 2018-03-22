-- Tables

CREATE TABLE city (
    id integer NOT NULL,
    name character varying(60) NOT NULL,
    country_id integer NOT NULL
);

CREATE TABLE "comment" (
    id integer NOT NULL,
    content text NOT NULL,
    "date" timestamp with time zone DEFAULT now() NOT NULL,
    removed_reason text,
    removed_date date,
    post_id integer NOT NULL,
    author_id integer NOT NULL,
    CONSTRAINT valid_removed_date CHECK ((date < removed_date))
);

CREATE TABLE country (
    id integer NOT NULL,
    name character varying(50) NOT NULL
);

CREATE TABLE faculty (
    id integer NOT NULL,
    name character varying(150) NOT NULL,
    description text NOT NULL,
    city_id integer NOT NULL
);

CREATE TABLE flag_comment (
    flagger_id integer NOT NULL,
    comment_id integer NOT NULL,
    reason text NOT NULL,
    "date" timestamp with time zone DEFAULT now() NOT NULL
);


CREATE TABLE flag_post (
    flagger_id integer NOT NULL,
    post_id integer NOT NULL,
    reason text NOT NULL,
    "date" timestamp with time zone NOT NULL
);

CREATE TABLE flag_user (
    flagger_id integer NOT NULL,
    flagged_id integer NOT NULL,
    reason text NOT NULL,
    "date" timestamp with time zone DEFAULT now() NOT NULL
);

CREATE TABLE following (
    follower_id integer NOT NULL,
    followed_id integer NOT NULL,
    "date" date DEFAULT now() NOT NULL
);

CREATE TABLE post (
    id integer NOT NULL,
    title character varying(200) NOT NULL,
    upvotes integer DEFAULT 0 NOT NULL,
    content text NOT NULL,
    school_year integer NOT NULL,
    "date" timestamp with time zone DEFAULT now() NOT NULL,
    removed_reason text,
    removed_date date,
    author_id integer NOT NULL,
    from_faculty_id integer NOT NULL,
    to_faculty_id integer NOT NULL,
    CONSTRAINT valid_removed_date CHECK ((date < removed_date))
);

CREATE TABLE university (
    id integer NOT NULL,
    name character varying(150) NOT NULL,
    description text NOT NULL,
    country_id integer NOT NULL
);

CREATE TABLE "user" (
    id integer NOT NULL,
    email character varying(100) NOT NULL,
    username character varying(100) NOT NULL,
    birthdate date,
    password character varying(60) NOT NULL,
    name character varying(150),
    register_date timestamp with time zone DEFAULT now() NOT NULL,
    description text,
    last_login timestamp with time zone,
    "type" character varying(50) NOT NULL,
    CONSTRAINT user_type CHECK (((type)::text = ANY (ARRAY['active'::text, 
                                                           'banned'::text, 
                                                           'admin'::text]))),
    CONSTRAINT valid_birthdate CHECK ((birthdate < register_date)),
    CONSTRAINT valid_last_login CHECK ((last_login > register_date))
);

CREATE TABLE upvote (
    user_id integer NOT NULL,
    post_id integer NOT NULL
);


-- Primary Keys and Uniques


ALTER TABLE ONLY city ADD CONSTRAINT city_pkey PRIMARY KEY (id);

ALTER TABLE ONLY "comment" ADD CONSTRAINT comment_pkey PRIMARY KEY (id);

ALTER TABLE ONLY country ADD CONSTRAINT country_pkey PRIMARY KEY (id);

ALTER TABLE ONLY faculty ADD CONSTRAINT faculty_pkey PRIMARY KEY (id);

ALTER TABLE ONLY flag_comment ADD CONSTRAINT flag_comment_pkey PRIMARY KEY 
(flagger_id, comment_id);

ALTER TABLE ONLY flag_post ADD CONSTRAINT flag_post_pkey PRIMARY KEY 
(flagger_id, post_id);

ALTER TABLE ONLY flag_user ADD CONSTRAINT flag_user_pkey PRIMARY KEY 
(flagger_id, flagged_id);

ALTER TABLE ONLY following ADD CONSTRAINT following_pkey PRIMARY KEY 
(follower_id, followed_id);

ALTER TABLE ONLY post ADD CONSTRAINT post_pkey PRIMARY KEY (id);

ALTER TABLE ONLY university ADD CONSTRAINT university_pkey PRIMARY KEY (id);

ALTER TABLE ONLY "user" ADD CONSTRAINT user_pkey PRIMARY KEY (id);

ALTER TABLE ONLY upvote ADD CONSTRAINT upvote_pkey PRIMARY KEY (user_id, post_id);

ALTER TABLE ONLY "user" ADD CONSTRAINT user_email_key UNIQUE (email);

ALTER TABLE ONLY "user" ADD CONSTRAINT user_username_key UNIQUE (username);



-- Foreign Keys

ALTER TABLE ONLY city ADD CONSTRAINT city_country_id_fkey FOREIGN KEY (country_id) 
REFERENCES country(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY "comment" ADD CONSTRAINT comment_author_id_fkey FOREIGN KEY
(author_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY "comment" ADD CONSTRAINT comment_post_id_fkey FOREIGN KEY (post_id) 
REFERENCES post(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY faculty ADD CONSTRAINT faculty_city_id_fkey FOREIGN KEY (city_id) 
REFERENCES city(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY flag_comment ADD CONSTRAINT flag_comment_comment_id_fkey FOREIGN KEY 
(comment_id) REFERENCES "comment"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY flag_comment ADD CONSTRAINT flag_comment_flagger_id_fkey FOREIGN KEY 
(flagger_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY flag_post ADD CONSTRAINT flag_post_flagger_id_fkey FOREIGN KEY 
(flagger_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY flag_post ADD CONSTRAINT flag_post_post_id_fkey FOREIGN KEY 
(post_id) REFERENCES post(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY flag_user ADD CONSTRAINT flag_user_flagged_id_fkey FOREIGN KEY 
(flagged_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY flag_user ADD CONSTRAINT flag_user_flagger_id_fkey FOREIGN KEY 
(flagger_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY following ADD CONSTRAINT following_followed_id_fkey FOREIGN KEY 
(followed_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY following ADD CONSTRAINT following_follower_id_fkey FOREIGN KEY 
(follower_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY post ADD CONSTRAINT post_author_id_fkey FOREIGN KEY 
(author_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY post ADD CONSTRAINT post_from_faculty_id_fkey FOREIGN KEY 
(from_faculty_id) REFERENCES faculty(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY post ADD CONSTRAINT post_to_faculty_id_fkey FOREIGN KEY 
(to_faculty_id) REFERENCES faculty(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY university ADD CONSTRAINT university_country_id_fkey FOREIGN KEY 
(country_id) REFERENCES country(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY upvote ADD CONSTRAINT upvote_post_id_fkey FOREIGN KEY (post_id) 
REFERENCES post(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY upvote ADD CONSTRAINT upvote_user_id_fkey1 FOREIGN KEY (user_id) 
REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;
