
--
-- Name: max_two_mobilities_per_year(); Type: FUNCTION; Schema: public; Owner: lbaw1721
--

CREATE FUNCTION max_two_mobilities_per_year() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    count_mobilities numeric;
BEGIN
    SELECT COUNT(id) INTO count_mobilities FROM post WHERE 
        NEW.author_id = author_id AND NEW.school_year = school_year;
    IF count_mobilities = 2 THEN
      RAISE EXCEPTION 'A user cannot participate in more than two mobilities per year, one per semester.';
    END IF;
    RETURN NEW;
END
$$;


--
-- Name: post_search_update(); Type: FUNCTION; Schema: public; Owner: lbaw1721
--

CREATE FUNCTION post_search_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.search_title = to_tsvector('english' , NEW.title);
    NEW.search_content = to_tsvector('english' , NEW.content);
  END IF;
  IF TG_OP = 'UPDATE' THEN
      IF NEW.title <> OLD.title THEN
        NEW.search_title = to_tsvector('english', NEW.title);
      END IF;
      IF NEW.content <> OLD.content THEN
        NEW.search_content = to_tsvector('english', NEW.content);
      END IF;
  END IF;
  RETURN NEW;
END
$$;


--
-- Name: update_vote(); Type: FUNCTION; Schema: public; Owner: lbaw1721
--

CREATE FUNCTION update_vote() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
    count_votes numeric;
BEGIN
    UPDATE post SET votes = (SELECT COUNT(CASE WHEN post_id=NEW.post_id THEN 1 END) AS c FROM vote)
    WHERE id=NEW.post_id;
    RETURN NEW;
END
$$;


--
-- Name: user_prevent_self_flag_comment(); Type: FUNCTION; Schema: public; Owner: lbaw1721
--

CREATE FUNCTION user_prevent_self_flag_comment() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF EXISTS (SELECT id FROM comment WHERE NEW.comment_id = id 
               AND NEW.flagger_id = author_id) THEN
      RAISE EXCEPTION 'A user cannot flag own post.';
    END IF;
    RETURN NEW;
END
$$;



--
-- Name: vote_prevent_own_user(); Type: FUNCTION; Schema: public; Owner: lbaw1721
--

CREATE FUNCTION vote_prevent_own_user() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF EXISTS (SELECT id FROM post WHERE NEW.post_id = id 
               AND NEW.user_id = author_id) THEN
      RAISE EXCEPTION 'A user cannot vote on own post.';
    END IF;
    RETURN NEW;
END
$$;


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: city; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE city (
    id integer NOT NULL,
    name character varying(60) NOT NULL,
    country_id integer NOT NULL
);


--
-- Name: city_id_seq; Type: SEQUENCE; Schema: public; Owner: lbaw1721
--

CREATE SEQUENCE city_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: city_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lbaw1721
--

ALTER SEQUENCE city_id_seq OWNED BY city.id;


--
-- Name: comment; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE comment (
    id integer NOT NULL,
    content text NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    removed_reason text,
    removed_date date,
    post_id integer NOT NULL,
    author_id integer NOT NULL,
    CONSTRAINT valid_removed_date CHECK ((date < removed_date))
);




--
-- Name: comment_id_seq; Type: SEQUENCE; Schema: public; Owner: lbaw1721
--

CREATE SEQUENCE comment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;




--
-- Name: comment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lbaw1721
--

ALTER SEQUENCE comment_id_seq OWNED BY comment.id;


--
-- Name: count_votes; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE count_votes (
    count bigint
);




--
-- Name: country; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE country (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    code character(2) NOT NULL
);




--
-- Name: country_id_seq; Type: SEQUENCE; Schema: public; Owner: lbaw1721
--

CREATE SEQUENCE country_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;




--
-- Name: country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lbaw1721
--

ALTER SEQUENCE country_id_seq OWNED BY country.id;


--
-- Name: faculty; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE faculty (
    id integer NOT NULL,
    name character varying(150) NOT NULL,
    description text NOT NULL,
    city_id integer NOT NULL,
    university_id integer
);




--
-- Name: faculty_id_seq; Type: SEQUENCE; Schema: public; Owner: lbaw1721
--

CREATE SEQUENCE faculty_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;




--
-- Name: faculty_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lbaw1721
--

ALTER SEQUENCE faculty_id_seq OWNED BY faculty.id;


--
-- Name: flag_comment; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE flag_comment (
    flagger_id integer NOT NULL,
    comment_id integer NOT NULL,
    reason text NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    archived boolean DEFAULT false NOT NULL
);




--
-- Name: flag_post; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE flag_post (
    flagger_id integer NOT NULL,
    post_id integer NOT NULL,
    reason text NOT NULL,
    date timestamp with time zone NOT NULL,
    archived boolean DEFAULT false NOT NULL
);




--
-- Name: flag_user; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE flag_user (
    flagger_id integer NOT NULL,
    flagged_id integer NOT NULL,
    reason text NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    archived boolean DEFAULT false NOT NULL
);




--
-- Name: following; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE following (
    follower_id integer NOT NULL,
    followed_id integer NOT NULL,
    date date DEFAULT now() NOT NULL,
    CONSTRAINT cannot_follow_oneself CHECK ((follower_id <> followed_id))
);




--
-- Name: post; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE post (
    id integer NOT NULL,
    title character varying(200) NOT NULL,
    votes integer DEFAULT 0 NOT NULL,
    content text NOT NULL,
    school_year integer NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    removed_reason text,
    removed_date date,
    author_id integer NOT NULL,
    from_faculty_id integer NOT NULL,
    to_faculty_id integer NOT NULL,
    beer_cost character varying(25),
    life_cost character varying(25),
    native_friendliness character varying(25),
    work_load character varying(15),
    search_title tsvector,
    search_content tsvector,
    CONSTRAINT valid_removed_date CHECK ((date < removed_date))
);




--
-- Name: COLUMN post.votes; Type: COMMENT; Schema: public; Owner: lbaw1721
--

COMMENT ON COLUMN post.votes IS 'Calculated Field';


--
-- Name: post_from_faculty_id_seq; Type: SEQUENCE; Schema: public; Owner: lbaw1721
--

CREATE SEQUENCE post_from_faculty_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;




--
-- Name: post_from_faculty_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lbaw1721
--

ALTER SEQUENCE post_from_faculty_id_seq OWNED BY post.from_faculty_id;


--
-- Name: post_id_seq; Type: SEQUENCE; Schema: public; Owner: lbaw1721
--

CREATE SEQUENCE post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;




--
-- Name: post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lbaw1721
--

ALTER SEQUENCE post_id_seq OWNED BY post.id;


--
-- Name: university; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE university (
    id integer NOT NULL,
    name character varying(150) NOT NULL,
    description text NOT NULL,
    country_id integer NOT NULL
);




--
-- Name: university_id_seq; Type: SEQUENCE; Schema: public; Owner: lbaw1721
--

CREATE SEQUENCE university_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;




--
-- Name: university_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lbaw1721
--

ALTER SEQUENCE university_id_seq OWNED BY university.id;


SET default_with_oids = true;

--
-- Name: user; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

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
    type character varying(50) NOT NULL,
    CONSTRAINT user_type CHECK (((type)::text = ANY (ARRAY['active'::text, 'banned'::text, 'admin'::text]))),
    CONSTRAINT valid_birthdate CHECK ((birthdate < register_date)),
    CONSTRAINT valid_last_login CHECK ((last_login > register_date))
);




--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: lbaw1721
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;




--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lbaw1721
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


SET default_with_oids = false;

--
-- Name: vote; Type: TABLE; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE TABLE vote (
    user_id integer NOT NULL,
    post_id integer NOT NULL
);




--
-- Name: id; Type: DEFAULT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY city ALTER COLUMN id SET DEFAULT nextval('city_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY comment ALTER COLUMN id SET DEFAULT nextval('comment_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY country ALTER COLUMN id SET DEFAULT nextval('country_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY faculty ALTER COLUMN id SET DEFAULT nextval('faculty_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY post ALTER COLUMN id SET DEFAULT nextval('post_id_seq'::regclass);


--
-- Name: from_faculty_id; Type: DEFAULT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY post ALTER COLUMN from_faculty_id SET DEFAULT nextval('post_from_faculty_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY university ALTER COLUMN id SET DEFAULT nextval('university_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- Data for Name: city; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO city VALUES (1, 'Porto', 1);
INSERT INTO city VALUES (2, 'Sheffield', 2);
INSERT INTO city VALUES (9, 'Xikou', 4);
INSERT INTO city VALUES (10, 'Siquanpu', 2);
INSERT INTO city VALUES (11, 'Svetogorsk', 7);
INSERT INTO city VALUES (12, 'Gaoyang', 5);
INSERT INTO city VALUES (13, 'Argotirto Krajan', 8);
INSERT INTO city VALUES (14, 'Krajan Tambakrejo', 7);
INSERT INTO city VALUES (15, 'San Lucas', 7);
INSERT INTO city VALUES (16, 'Corinto', 3);
INSERT INTO city VALUES (17, 'Wenquan', 3);
INSERT INTO city VALUES (3, 'Simenqian', 2);
INSERT INTO city VALUES (4, 'Kungsbacka', 6);
INSERT INTO city VALUES (5, 'Jati', 1);
INSERT INTO city VALUES (6, 'Bacnar', 8);
INSERT INTO city VALUES (7, 'Maria', 9);
INSERT INTO city VALUES (8, 'Aroa', 9);


--
-- Name: city_id_seq; Type: SEQUENCE SET; Schema: public; Owner: lbaw1721
--

SELECT pg_catalog.setval('city_id_seq', 62, true);


--
-- Data for Name: comment; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO comment VALUES (16, 'Supplement Right 3rd Toe with Autol Sub, Perc Endo Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 10, 29);
INSERT INTO comment VALUES (18, 'Removal of Infusion Dev from L Carpal Jt, Perc Endo Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 13, 12);
INSERT INTO comment VALUES (22, 'Extirpation of Matter from Lumbosacral Plexus, Perc Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 9, 19);
INSERT INTO comment VALUES (23, 'Revision of Infusion Device in Fem Perineum, Extern Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 8, 29);
INSERT INTO comment VALUES (24, 'Remove of Infusion Dev from Vas Deferens, Perc Endo Approach', '2018-03-22 11:16:36.111183+00', 'European Privet', '2018-03-23', 7, 4);
INSERT INTO comment VALUES (25, 'Repair Right Foot Muscle, Percutaneous Endoscopic Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 15, 9);
INSERT INTO comment VALUES (26, 'Lower Veins, Excision', '2018-03-22 11:16:36.111183+00', NULL, NULL, 9, 13);
INSERT INTO comment VALUES (27, 'Fusion of Sacrococcygeal Jt with Nonaut Sub, Perc Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 7, 25);
INSERT INTO comment VALUES (28, 'Supplement Pericardium with Autol Sub, Perc Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 13, 14);
INSERT INTO comment VALUES (29, 'Extirpation of Matter from Intracran Art, Open Approach', '2018-03-22 11:16:36.111183+00', 'Cuban Copperleaf', '2018-03-23', 15, 3);
INSERT INTO comment VALUES (30, 'Drainage of Left Axilla with Drainage Device, Perc Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 13, 17);
INSERT INTO comment VALUES (32, 'Bypass 2 Cor Art from R Int Mammary w Zooplastic, Open', '2018-03-22 11:16:36.111183+00', NULL, NULL, 7, 7);
INSERT INTO comment VALUES (33, 'Supplement L Shoulder Bursa/Lig w Synth Sub, Perc Endo', '2018-03-22 11:16:36.111183+00', NULL, NULL, 3, 6);
INSERT INTO comment VALUES (34, 'Removal of Autol Sub from L Glenoid Cav, Open Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 9, 3);
INSERT INTO comment VALUES (3, 'Destruction of Brain, Percutaneous Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 2, 11);
INSERT INTO comment VALUES (6, 'Fusion of Right Metatarsal-Tarsal Joint, Perc Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 2, 20);
INSERT INTO comment VALUES (8, 'Removal of Synth Sub from R Carpal Jt, Perc Approach', '2018-03-22 11:16:36.111183+00', 'Quillwort', '2018-03-23', 12, 4);
INSERT INTO comment VALUES (7, 'Beam Radiation of Right Breast using Electrons, Intraop', '2018-03-22 11:16:36.111183+00', NULL, NULL, 14, 19);
INSERT INTO comment VALUES (12, 'Reattachment of Right Upper Leg Muscle, Perc Endo Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 5, 8);
INSERT INTO comment VALUES (11, 'Supplement Inf Mesent Vein with Nonaut Sub, Perc Approach', '2018-03-22 11:16:36.111183+00', NULL, NULL, 6, 4);


--
-- Name: comment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: lbaw1721
--

SELECT pg_catalog.setval('comment_id_seq', 34, true);


--
-- Data for Name: count_votes; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO count_votes VALUES (15);


--
-- Data for Name: country; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO country VALUES (1, 'Portugal', 'pt');
INSERT INTO country VALUES (2, 'United Kingdom', 'gb');
INSERT INTO country VALUES (3, 'Afghanistan', 'af');
INSERT INTO country VALUES (4, 'Aland Islands', 'ax');
INSERT INTO country VALUES (5, 'Albania', 'al');
INSERT INTO country VALUES (6, 'Algeria', 'dz');
INSERT INTO country VALUES (7, 'American Samoa', 'as');
INSERT INTO country VALUES (8, 'Andorra', 'ad');
INSERT INTO country VALUES (9, 'Angola', 'ao');
INSERT INTO country VALUES (10, 'Anguilla', 'ai');
INSERT INTO country VALUES (11, 'Antarctica', 'aq');
INSERT INTO country VALUES (12, 'Antigua and Barbuda', 'ag');
INSERT INTO country VALUES (13, 'Argentina', 'ar');
INSERT INTO country VALUES (14, 'Armenia', 'am');
INSERT INTO country VALUES (15, 'Aruba', 'aw');
INSERT INTO country VALUES (16, 'Australia', 'au');
INSERT INTO country VALUES (17, 'Austria', 'at');
INSERT INTO country VALUES (18, 'Azerbaijan', 'az');
INSERT INTO country VALUES (19, 'Bahamas', 'bs');
INSERT INTO country VALUES (20, 'Bahrain', 'bh');
INSERT INTO country VALUES (21, 'Bangladesh', 'bd');
INSERT INTO country VALUES (22, 'Barbados', 'bb');
INSERT INTO country VALUES (23, 'Belarus', 'by');
INSERT INTO country VALUES (24, 'Belgium', 'be');
INSERT INTO country VALUES (25, 'Belize', 'bz');
INSERT INTO country VALUES (26, 'Benin', 'bj');
INSERT INTO country VALUES (27, 'Bermuda', 'bm');
INSERT INTO country VALUES (28, 'Bhutan', 'bt');
INSERT INTO country VALUES (29, 'Bolivia', 'bo');
INSERT INTO country VALUES (30, 'Bosnia and Herzegovina', 'ba');
INSERT INTO country VALUES (31, 'Botswana', 'bw');
INSERT INTO country VALUES (32, 'Bouvet Island', 'bv');
INSERT INTO country VALUES (33, 'Brazil', 'br');
INSERT INTO country VALUES (34, 'British Virgin Islands', 'vg');
INSERT INTO country VALUES (35, 'British Indian Ocean Territory', 'io');
INSERT INTO country VALUES (36, 'Brunei Darussalam', 'bn');
INSERT INTO country VALUES (37, 'Bulgaria', 'bg');
INSERT INTO country VALUES (38, 'Burkina Faso', 'bf');
INSERT INTO country VALUES (39, 'Burundi', 'bi');
INSERT INTO country VALUES (40, 'Cambodia', 'kh');
INSERT INTO country VALUES (41, 'Cameroon', 'cm');
INSERT INTO country VALUES (42, 'Canada', 'ca');
INSERT INTO country VALUES (43, 'Cape Verde', 'cv');
INSERT INTO country VALUES (44, 'Cayman Islands', 'ky');
INSERT INTO country VALUES (45, 'Central African Republic', 'cf');
INSERT INTO country VALUES (46, 'Chad', 'td');
INSERT INTO country VALUES (47, 'Chile', 'cl');
INSERT INTO country VALUES (48, 'China', 'cn');
INSERT INTO country VALUES (49, 'Hong Kong, SAR China', 'hk');
INSERT INTO country VALUES (50, 'Macao, SAR China', 'mo');
INSERT INTO country VALUES (51, 'Christmas Island', 'cx');
INSERT INTO country VALUES (52, 'Cocos (Keeling) Islands', 'cc');
INSERT INTO country VALUES (53, 'Colombia', 'co');
INSERT INTO country VALUES (54, 'Comoros', 'km');
INSERT INTO country VALUES (55, 'Congo (Brazzaville)', 'cg');
INSERT INTO country VALUES (56, 'Congo, (Kinshasa)', 'cd');
INSERT INTO country VALUES (57, 'Cook Islands', 'ck');
INSERT INTO country VALUES (58, 'Costa Rica', 'cr');
INSERT INTO country VALUES (59, 'Côte d''Ivoire', 'ci');
INSERT INTO country VALUES (60, 'Croatia', 'hr');
INSERT INTO country VALUES (61, 'Cuba', 'cu');
INSERT INTO country VALUES (62, 'Cyprus', 'cy');
INSERT INTO country VALUES (63, 'Czech Republic', 'cz');
INSERT INTO country VALUES (64, 'Denmark', 'dk');
INSERT INTO country VALUES (65, 'Djibouti', 'dj');
INSERT INTO country VALUES (66, 'Dominica', 'dm');
INSERT INTO country VALUES (67, 'Dominican Republic', 'do');
INSERT INTO country VALUES (68, 'Ecuador', 'ec');
INSERT INTO country VALUES (69, 'Egypt', 'eg');
INSERT INTO country VALUES (70, 'El Salvador', 'sv');
INSERT INTO country VALUES (71, 'Equatorial Guinea', 'gq');
INSERT INTO country VALUES (72, 'Eritrea', 'er');
INSERT INTO country VALUES (73, 'Estonia', 'ee');
INSERT INTO country VALUES (74, 'Ethiopia', 'et');
INSERT INTO country VALUES (75, 'Falkland Islands (Malvinas)', 'fk');
INSERT INTO country VALUES (76, 'Faroe Islands', 'fo');
INSERT INTO country VALUES (77, 'Fiji', 'fj');
INSERT INTO country VALUES (78, 'Finland', 'fi');
INSERT INTO country VALUES (79, 'France', 'fr');
INSERT INTO country VALUES (80, 'French Guiana', 'gf');
INSERT INTO country VALUES (81, 'French Polynesia', 'pf');
INSERT INTO country VALUES (82, 'French Southern Territories', 'tf');
INSERT INTO country VALUES (83, 'Gabon', 'ga');
INSERT INTO country VALUES (84, 'Gambia', 'gm');
INSERT INTO country VALUES (85, 'Georgia', 'ge');
INSERT INTO country VALUES (86, 'Germany', 'de');
INSERT INTO country VALUES (87, 'Ghana', 'gh');
INSERT INTO country VALUES (88, 'Gibraltar', 'gi');
INSERT INTO country VALUES (89, 'Greece', 'gr');
INSERT INTO country VALUES (90, 'Greenland', 'gl');
INSERT INTO country VALUES (91, 'Grenada', 'gd');
INSERT INTO country VALUES (92, 'Guadeloupe', 'gp');
INSERT INTO country VALUES (93, 'Guam', 'gu');
INSERT INTO country VALUES (94, 'Guatemala', 'gt');
INSERT INTO country VALUES (95, 'Guernsey', 'gg');
INSERT INTO country VALUES (96, 'Guinea', 'gn');
INSERT INTO country VALUES (97, 'Guinea-Bissau', 'gw');
INSERT INTO country VALUES (98, 'Guyana', 'gy');
INSERT INTO country VALUES (99, 'Haiti', 'ht');
INSERT INTO country VALUES (100, 'Heard and Mcdonald Islands', 'hm');
INSERT INTO country VALUES (101, 'Holy See (Vatican City State)', 'va');
INSERT INTO country VALUES (102, 'Honduras', 'hn');
INSERT INTO country VALUES (103, 'Hungary', 'hu');
INSERT INTO country VALUES (104, 'Iceland', 'is');
INSERT INTO country VALUES (105, 'India', 'in');
INSERT INTO country VALUES (106, 'Indonesia', 'id');
INSERT INTO country VALUES (107, 'Iran, Islamic Republic of', 'ir');
INSERT INTO country VALUES (108, 'Iraq', 'iq');
INSERT INTO country VALUES (109, 'Ireland', 'ie');
INSERT INTO country VALUES (110, 'Isle of Man', 'im');
INSERT INTO country VALUES (111, 'Israel', 'il');
INSERT INTO country VALUES (112, 'Italy', 'it');
INSERT INTO country VALUES (113, 'Jamaica', 'jm');
INSERT INTO country VALUES (114, 'Japan', 'jp');
INSERT INTO country VALUES (115, 'Jersey', 'je');
INSERT INTO country VALUES (116, 'Jordan', 'jo');
INSERT INTO country VALUES (117, 'Kazakhstan', 'kz');
INSERT INTO country VALUES (118, 'Kenya', 'ke');
INSERT INTO country VALUES (119, 'Kiribati', 'ki');
INSERT INTO country VALUES (120, 'Korea (North)', 'kp');
INSERT INTO country VALUES (121, 'Korea (South)', 'kr');
INSERT INTO country VALUES (122, 'Kuwait', 'kw');
INSERT INTO country VALUES (123, 'Kyrgyzstan', 'kg');
INSERT INTO country VALUES (124, 'Lao PDR', 'la');
INSERT INTO country VALUES (125, 'Latvia', 'lv');
INSERT INTO country VALUES (126, 'Lebanon', 'lb');
INSERT INTO country VALUES (127, 'Lesotho', 'ls');
INSERT INTO country VALUES (128, 'Liberia', 'lr');
INSERT INTO country VALUES (129, 'Libya', 'ly');
INSERT INTO country VALUES (130, 'Liechtenstein', 'li');
INSERT INTO country VALUES (131, 'Lithuania', 'lt');
INSERT INTO country VALUES (132, 'Luxembourg', 'lu');
INSERT INTO country VALUES (133, 'Macedonia, Republic of', 'mk');
INSERT INTO country VALUES (134, 'Madagascar', 'mg');
INSERT INTO country VALUES (135, 'Malawi', 'mw');
INSERT INTO country VALUES (136, 'Malaysia', 'my');
INSERT INTO country VALUES (137, 'Maldives', 'mv');
INSERT INTO country VALUES (138, 'Mali', 'ml');
INSERT INTO country VALUES (139, 'Malta', 'mt');
INSERT INTO country VALUES (140, 'Marshall Islands', 'mh');
INSERT INTO country VALUES (141, 'Martinique', 'mq');
INSERT INTO country VALUES (142, 'Mauritania', 'mr');
INSERT INTO country VALUES (143, 'Mauritius', 'mu');
INSERT INTO country VALUES (144, 'Mayotte', 'yt');
INSERT INTO country VALUES (145, 'Mexico', 'mx');
INSERT INTO country VALUES (146, 'Micronesia, Federated States of', 'fm');
INSERT INTO country VALUES (147, 'Moldova', 'md');
INSERT INTO country VALUES (148, 'Monaco', 'mc');
INSERT INTO country VALUES (149, 'Mongolia', 'mn');
INSERT INTO country VALUES (150, 'Montenegro', 'me');
INSERT INTO country VALUES (151, 'Montserrat', 'ms');
INSERT INTO country VALUES (152, 'Morocco', 'ma');
INSERT INTO country VALUES (153, 'Mozambique', 'mz');
INSERT INTO country VALUES (154, 'Myanmar', 'mm');
INSERT INTO country VALUES (155, 'Namibia', 'na');
INSERT INTO country VALUES (156, 'Nauru', 'nr');
INSERT INTO country VALUES (157, 'Nepal', 'np');
INSERT INTO country VALUES (158, 'Netherlands', 'nl');
INSERT INTO country VALUES (159, 'Netherlands Antilles', 'an');
INSERT INTO country VALUES (160, 'New Caledonia', 'nc');
INSERT INTO country VALUES (161, 'New Zealand', 'nz');
INSERT INTO country VALUES (162, 'Nicaragua', 'ni');
INSERT INTO country VALUES (163, 'Niger', 'ne');
INSERT INTO country VALUES (164, 'Nigeria', 'ng');
INSERT INTO country VALUES (165, 'Niue', 'nu');
INSERT INTO country VALUES (166, 'Norfolk Island', 'nf');
INSERT INTO country VALUES (167, 'Northern Mariana Islands', 'mp');
INSERT INTO country VALUES (168, 'Norway', 'no');
INSERT INTO country VALUES (169, 'Oman', 'om');
INSERT INTO country VALUES (170, 'Pakistan', 'pk');
INSERT INTO country VALUES (171, 'Palau', 'pw');
INSERT INTO country VALUES (172, 'Palestinian Territory', 'ps');
INSERT INTO country VALUES (173, 'Panama', 'pa');
INSERT INTO country VALUES (174, 'Papua New Guinea', 'pg');
INSERT INTO country VALUES (175, 'Paraguay', 'py');
INSERT INTO country VALUES (176, 'Peru', 'pe');
INSERT INTO country VALUES (177, 'Philippines', 'ph');
INSERT INTO country VALUES (178, 'Pitcairn', 'pn');
INSERT INTO country VALUES (179, 'Poland', 'pl');
INSERT INTO country VALUES (181, 'Puerto Rico', 'pr');
INSERT INTO country VALUES (182, 'Qatar', 'qa');
INSERT INTO country VALUES (183, 'Réunion', 're');
INSERT INTO country VALUES (184, 'Romania', 'ro');
INSERT INTO country VALUES (185, 'Russian Federation', 'ru');
INSERT INTO country VALUES (186, 'Rwanda', 'rw');
INSERT INTO country VALUES (187, 'Saint-Barthélemy', 'bl');
INSERT INTO country VALUES (188, 'Saint Helena', 'sh');
INSERT INTO country VALUES (189, 'Saint Kitts and Nevis', 'kn');
INSERT INTO country VALUES (190, 'Saint Lucia', 'lc');
INSERT INTO country VALUES (191, 'Saint-Martin (French part)', 'mf');
INSERT INTO country VALUES (192, 'Saint Pierre and Miquelon', 'pm');
INSERT INTO country VALUES (193, 'Saint Vincent and Grenadines', 'vc');
INSERT INTO country VALUES (194, 'Samoa', 'ws');
INSERT INTO country VALUES (195, 'San Marino', 'sm');
INSERT INTO country VALUES (196, 'Sao Tome and Principe', 'st');
INSERT INTO country VALUES (197, 'Saudi Arabia', 'sa');
INSERT INTO country VALUES (198, 'Senegal', 'sn');
INSERT INTO country VALUES (199, 'Serbia', 'rs');
INSERT INTO country VALUES (200, 'Seychelles', 'sc');
INSERT INTO country VALUES (201, 'Sierra Leone', 'sl');
INSERT INTO country VALUES (202, 'Singapore', 'sg');
INSERT INTO country VALUES (203, 'Slovakia', 'sk');
INSERT INTO country VALUES (204, 'Slovenia', 'si');
INSERT INTO country VALUES (205, 'Solomon Islands', 'sb');
INSERT INTO country VALUES (206, 'Somalia', 'so');
INSERT INTO country VALUES (207, 'South Africa', 'za');
INSERT INTO country VALUES (208, 'South Georgia and the South Sandwich Islands', 'gs');
INSERT INTO country VALUES (209, 'South Sudan', 'ss');
INSERT INTO country VALUES (210, 'Spain', 'es');
INSERT INTO country VALUES (211, 'Sri Lanka', 'lk');
INSERT INTO country VALUES (212, 'Sudan', 'sd');
INSERT INTO country VALUES (213, 'Suriname', 'sr');
INSERT INTO country VALUES (214, 'Svalbard and Jan Mayen Islands', 'sj');
INSERT INTO country VALUES (215, 'Swaziland', 'sz');
INSERT INTO country VALUES (216, 'Sweden', 'se');
INSERT INTO country VALUES (217, 'Switzerland', 'ch');
INSERT INTO country VALUES (218, 'Syrian Arab Republic (Syria)', 'sy');
INSERT INTO country VALUES (219, 'Taiwan, Republic of China', 'tw');
INSERT INTO country VALUES (220, 'Tajikistan', 'tj');
INSERT INTO country VALUES (221, 'Tanzania, United Republic of', 'tz');
INSERT INTO country VALUES (222, 'Thailand', 'th');
INSERT INTO country VALUES (223, 'Timor-Leste', 'tl');
INSERT INTO country VALUES (224, 'Togo', 'tg');
INSERT INTO country VALUES (225, 'Tokelau', 'tk');
INSERT INTO country VALUES (226, 'Tonga', 'to');
INSERT INTO country VALUES (227, 'Trinidad and Tobago', 'tt');
INSERT INTO country VALUES (228, 'Tunisia', 'tn');
INSERT INTO country VALUES (229, 'Turkey', 'tr');
INSERT INTO country VALUES (230, 'Turkmenistan', 'tm');
INSERT INTO country VALUES (231, 'Turks and Caicos Islands', 'tc');
INSERT INTO country VALUES (232, 'Tuvalu', 'tv');
INSERT INTO country VALUES (233, 'Uganda', 'ug');
INSERT INTO country VALUES (234, 'Ukraine', 'ua');
INSERT INTO country VALUES (235, 'United Arab Emirates', 'ae');
INSERT INTO country VALUES (237, 'United States of America', 'us');
INSERT INTO country VALUES (238, 'US Minor Outlying Islands', 'um');
INSERT INTO country VALUES (239, 'Uruguay', 'uy');
INSERT INTO country VALUES (240, 'Uzbekistan', 'uz');
INSERT INTO country VALUES (241, 'Vanuatu', 'vu');
INSERT INTO country VALUES (242, 'Venezuela (Bolivarian Republic)', 've');
INSERT INTO country VALUES (243, 'Viet Nam', 'vn');
INSERT INTO country VALUES (244, 'Virgin Islands, US', 'vi');
INSERT INTO country VALUES (245, 'Wallis and Futuna Islands', 'wf');
INSERT INTO country VALUES (246, 'Western Sahara', 'eh');
INSERT INTO country VALUES (247, 'Yemen', 'ye');
INSERT INTO country VALUES (248, 'Zambia', 'zm');
INSERT INTO country VALUES (249, 'Zimbabwe', 'zw');


--
-- Name: country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: lbaw1721
--

SELECT pg_catalog.setval('country_id_seq', 2, true);


--
-- Data for Name: faculty; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO faculty VALUES (1, 'Faculdade de Engenharia', '', 1, 1);
INSERT INTO faculty VALUES (2, 'Faculty of Engineering', '', 2, 2);
INSERT INTO faculty VALUES (5, 'University of Nicosia', 'Rosemary - Primerba, Paste', 9, 7);
INSERT INTO faculty VALUES (6, 'Southern Nazarene University', 'Pastry - Banana Tea Loaf', 12, 10);
INSERT INTO faculty VALUES (7, 'Universidad de Málaga', 'Flower - Commercial Bronze', 11, 8);
INSERT INTO faculty VALUES (8, 'Albion College', 'Bacardi Mojito', 14, 2);
INSERT INTO faculty VALUES (9, 'University of Virginia, College at Wise', 'V8 - Tropical Blend', 2, 14);
INSERT INTO faculty VALUES (10, 'Universidad Autónoma del Noreste', 'Extract - Rum', 7, 6);
INSERT INTO faculty VALUES (11, 'University of Kuopio', 'Flour - Chickpea', 2, 3);
INSERT INTO faculty VALUES (12, 'Newschool of Architecture and Design', 'Cinnamon - Stick', 3, 11);
INSERT INTO faculty VALUES (13, 'Saint Ferdinand College', 'Quail - Eggs, Fresh', 10, 11);
INSERT INTO faculty VALUES (14, 'Effat College', 'Extract - Almond', 13, 7);
INSERT INTO faculty VALUES (15, 'Skidmore College', 'Sauce - Bernaise, Mix', 15, 6);
INSERT INTO faculty VALUES (16, 'University of Zenica', 'Apple - Custard', 5, 3);
INSERT INTO faculty VALUES (17, 'Hogeschool West-Vlaanderen (TU)', 'Marzipan 50/50', 5, 1);
INSERT INTO faculty VALUES (18, 'Notre Dame de Namur University', 'Wine - Red, Marechal Foch', 2, 5);
INSERT INTO faculty VALUES (19, 'Effat College', 'Chambord Royal', 2, 3);
INSERT INTO faculty VALUES (20, 'Fontbonne College', 'Veal - Round, Eye Of', 2, 2);
INSERT INTO faculty VALUES (21, 'Rochester Institute of Technology', 'Figs', 10, 14);
INSERT INTO faculty VALUES (22, 'Universidad Nacional de Asunción', 'Peach - Fresh', 4, 14);
INSERT INTO faculty VALUES (23, 'Carthage College', 'Beef - Tenderloin Tails', 6, 10);
INSERT INTO faculty VALUES (3, 'Centre Universitaire de Technologie', 'Dried Peach', 9, 1);


--
-- Name: faculty_id_seq; Type: SEQUENCE SET; Schema: public; Owner: lbaw1721
--

SELECT pg_catalog.setval('faculty_id_seq', 24, true);


--
-- Data for Name: flag_comment; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO flag_comment VALUES (5, 12, 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.', '2018-03-22 11:16:36.111183+00', true);
INSERT INTO flag_comment VALUES (9, 3, 'Vestibulum justo.', '2018-03-22 11:16:36.111183+00', true);
INSERT INTO flag_comment VALUES (2, 11, 'Lorem rhoncus.', '2018-03-22 11:16:36.111183+00', false);
INSERT INTO flag_comment VALUES (8, 6, 'In tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', '2018-03-22 11:16:36.111183+00', true);
INSERT INTO flag_comment VALUES (9, 7, 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', '2018-03-22 11:16:36.111183+00', false);


--
-- Data for Name: flag_post; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO flag_post VALUES (11, 4, 'Universal clear-thinking process improvement', '2018-03-22 11:16:36.111183+00', false);
INSERT INTO flag_post VALUES (6, 11, 'Optional bandwidth-monitored flexibility', '2018-03-22 11:16:36.111183+00', true);
INSERT INTO flag_post VALUES (8, 12, 'Automated foreground customer loyalty', '2018-03-22 11:16:36.111183+00', true);
INSERT INTO flag_post VALUES (27, 4, 'Triple-buffered clear-thinking hub', '2018-03-22 11:16:36.111183+00', false);
INSERT INTO flag_post VALUES (17, 7, 'Fundamental full-range superstructure', '2018-03-22 11:16:36.111183+00', true);


--
-- Data for Name: flag_user; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO flag_user VALUES (6, 12, 'Exclusive reciprocal emulation', '2018-03-22 11:16:36.111183+00', false);
INSERT INTO flag_user VALUES (25, 8, 'De-engineered grid-enabled data-warehouse', '2018-03-22 11:16:36.111183+00', true);
INSERT INTO flag_user VALUES (16, 7, 'Quality-focused impactful support', '2018-03-22 11:16:36.111183+00', false);
INSERT INTO flag_user VALUES (9, 14, 'Up-sized analyzing function', '2018-03-22 11:16:36.111183+00', true);
INSERT INTO flag_user VALUES (1, 14, 'User-centric foreground forecast', '2018-03-22 11:16:36.111183+00', false);


--
-- Data for Name: following; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO following VALUES (4, 7, '2018-03-22');
INSERT INTO following VALUES (3, 14, '2018-03-22');
INSERT INTO following VALUES (4, 8, '2018-03-22');
INSERT INTO following VALUES (9, 5, '2018-03-22');
INSERT INTO following VALUES (1, 6, '2018-03-22');
INSERT INTO following VALUES (11, 12, '2018-03-22');
INSERT INTO following VALUES (24, 14, '2018-03-22');
INSERT INTO following VALUES (29, 14, '2018-03-22');
INSERT INTO following VALUES (15, 3, '2018-03-22');
INSERT INTO following VALUES (24, 11, '2018-03-22');
INSERT INTO following VALUES (25, 7, '2018-03-22');
INSERT INTO following VALUES (14, 13, '2018-03-22');
INSERT INTO following VALUES (27, 6, '2018-03-22');
INSERT INTO following VALUES (25, 8, '2018-03-22');
INSERT INTO following VALUES (11, 6, '2018-03-22');
INSERT INTO following VALUES (1, 13, '2018-03-22');
INSERT INTO following VALUES (19, 3, '2018-03-22');
INSERT INTO following VALUES (14, 15, '2018-03-22');
INSERT INTO following VALUES (17, 13, '2018-03-22');
INSERT INTO following VALUES (25, 12, '2018-03-22');
INSERT INTO following VALUES (1, 7, '2018-03-22');
INSERT INTO following VALUES (14, 8, '2018-03-22');
INSERT INTO following VALUES (8, 14, '2018-03-22');
INSERT INTO following VALUES (11, 3, '2018-03-22');
INSERT INTO following VALUES (14, 1, '2018-03-22');
INSERT INTO following VALUES (6, 5, '2018-03-22');
INSERT INTO following VALUES (29, 5, '2018-03-22');
INSERT INTO following VALUES (23, 14, '2018-03-22');


--
-- Data for Name: post; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO post VALUES (4, 'est donec odio justo sollicitudin ut suscipit a', 26, 'Sed ante. Vivamus tortor. Duis mattis egestas metus. Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', 2001, '2018-03-22 11:16:36.111183+00', NULL, NULL, 12, 5, 11, 'High', 'Cheap', 'Neutral', 'Accessible', '''donec'':2 ''est'':1 ''justo'':4 ''odio'':3 ''sollicitudin'':5 ''suscipit'':7 ''ut'':6', '''aenean'':9 ''ant'':2 ''conval'':17,21 ''donec'':11 ''dui'':5 ''egesta'':7 ''eget'':14,22 ''eleifend'':23 ''eu'':26 ''fermentum'':10 ''libero'':20 ''luctus'':24 ''massa'':15 ''matti'':6 ''mauri'':13 ''metus'':8 ''nequ'':19 ''nibh'':27 ''nulla'':18 ''sed'':1 ''tempor'':16 ''tortor'':4 ''ultrici'':25 ''ut'':12 ''vivamus'':3');
INSERT INTO post VALUES (1, 'libero convallis eget eleifend luctus ultricies eu nibh quisque id justo sit amet sapien dignissim vestibulum vestibulum ante ipsum primis', 21, 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh. Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', 2012, '2018-03-22 11:16:36.111183+00', NULL, NULL, 19, 17, 7, 'High', 'Cheap', 'Friendly', 'Easy', '''amet'':13 ''ant'':18 ''conval'':2 ''dignissim'':15 ''eget'':3 ''eleifend'':4 ''eu'':7 ''id'':10 ''ipsum'':19 ''justo'':11 ''libero'':1 ''luctus'':5 ''nibh'':8 ''primi'':20 ''quisqu'':9 ''sapien'':14 ''sit'':12 ''ultrici'':6 ''vestibulum'':16,17', '''aenean'':1 ''amet'':24 ''ant'':29 ''conval'':9,13 ''cubilia'':39 ''cura'':40 ''dapibus'':42 ''dignissim'':26 ''dolor'':43 ''donec'':3,46 ''eget'':6,14 ''eleifend'':15 ''ero'':55 ''est'':45 ''et'':36,54 ''eu'':18 ''faucibus'':33 ''fermentum'':2 ''feugiat'':53 ''id'':21 ''ipsum'':30 ''justo'':22,48 ''libero'':12 ''luctus'':16,35 ''massa'':7 ''mauri'':5 ''nequ'':11 ''nibh'':19 ''nulla'':10,41 ''odio'':47 ''orci'':34 ''posuer'':38 ''primi'':31 ''quisqu'':20 ''sapien'':25 ''sit'':23 ''sollicitudin'':49 ''suscipit'':51 ''tempor'':8 ''ultric'':37 ''ultrici'':17 ''ut'':4,50 ''vel'':44 ''vestibulum'':27,28');
INSERT INTO post VALUES (3, 'vestibulum ante ipsum primis in faucibus', 9, 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi. Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque. Quisque porta volutpat erat. Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla. Nunc purus.', 2006, '2018-03-22 11:16:36.111183+00', NULL, NULL, 21, 13, 5, 'High', 'Cheap', 'Neutral', 'Accessible', '''ant'':2 ''faucibus'':6 ''ipsum'':3 ''primi'':4 ''vestibulum'':1', '''congu'':40 ''cras'':12 ''eget'':27,39,41 ''elementum'':7,29 ''erat'':3,34,36 ''ero'':28,37 ''facilisi'':11 ''id'':4 ''lacus'':21 ''maecena'':19 ''mauri'':5 ''nec'':15 ''nisi'':16 ''non'':13 ''nonummi'':18 ''nulla'':1,10,26,44 ''nullam'':8 ''nunc'':45 ''pellentesqu'':30 ''porta'':32 ''purus'':46 ''quisqu'':31,35 ''rutrum'':43 ''semper'':42 ''tincidunt'':20 ''ut'':2 ''varius'':9 ''vel'':25 ''velit'':14,23 ''vivamus'':24 ''viverra'':38 ''volutpat'':33 ''vulput'':6,17');
INSERT INTO post VALUES (6, 'lacus at turpis donec posuere metus', 2, 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi. Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', 2003, '2018-03-22 11:16:36.111183+00', NULL, NULL, 25, 8, 20, 'Very Accessible', 'Accessible', 'Hostile', 'Medium', '''donec'':4 ''lacus'':1 ''metus'':6 ''posuer'':5 ''turpi'':3', '''cras'':12 ''eget'':27 ''elementum'':7,29 ''erat'':3 ''ero'':28 ''facilisi'':11 ''id'':4 ''lacus'':21 ''maecena'':19 ''mauri'':5 ''nec'':15 ''nisi'':16 ''non'':13 ''nonummi'':18 ''nulla'':1,10,26 ''nullam'':8 ''pellentesqu'':30 ''tincidunt'':20 ''ut'':2 ''varius'':9 ''vel'':25 ''velit'':14,23 ''vivamus'':24 ''vulput'':6,17');
INSERT INTO post VALUES (5, 'pellentesque ultrices phasellus id sapien in sapien iaculis congue vivamus metus arcu', 1, 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem. Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat. Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', 1999, '2018-03-22 11:16:36.111183+00', NULL, NULL, 9, 18, 8, 'Very Accessible', 'Cheap', 'Friendly', 'GAAAAAAH!', '''arcu'':12 ''congu'':9 ''iaculi'':8 ''id'':4 ''metus'':11 ''pellentesqu'':1 ''phasellus'':3 ''sapien'':5,7 ''ultric'':2 ''vivamus'':10', '''aliquam'':11 ''ant'':23 ''augu'':12 ''blandit'':27,38 ''commodo'':35 ''consectetu'':16 ''curabitur'':1 ''dictumst'':10 ''eget'':17,45,47 ''erat'':29 ''gravida'':2 ''habitass'':8 ''hac'':7 ''integ'':21,41 ''ipsum'':25 ''justo'':43 ''lacinia'':28,44 ''lorem'':20 ''magna'':32 ''nam'':39 ''nibh'':5 ''nisi'':3 ''nulla'':40 ''nunc'':34 ''pede'':42,50 ''placerat'':36 ''platea'':9 ''praesent'':26,37 ''quam'':13 ''rutrum'':18 ''sed'':31 ''sollicitudin'':14 ''tempus'':48 ''tincidunt'':22,46 ''vel'':24,49 ''vestibulum'':30 ''vita'':15');
INSERT INTO post VALUES (7, 'ligula sit amet eleifend pede libero quis orci nullam molestie nibh in lectus pellentesque at nulla', 16, 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.', 1998, '2018-03-22 11:16:36.111183+00', '2018-03-22 11:16:36.111183+00', NULL, 22, 5, 10, 'Too High', 'Accessible', 'Best People On Earth', 'Super Easy', '''amet'':3 ''eleifend'':4 ''lectus'':13 ''libero'':6 ''ligula'':1 ''molesti'':10 ''nibh'':11 ''nulla'':16 ''nullam'':9 ''orci'':8 ''pede'':5 ''pellentesqu'':14 ''qui'':7 ''sit'':2', '''ant'':21 ''condimentum'':17 ''diam'':12 ''dictumst'':5 ''erat'':13 ''fermentum'':14 ''habitass'':3 ''hac'':2 ''iaculi'':11 ''id'':9 ''justo'':15,23 ''morbi'':6 ''nec'':16 ''nequ'':18 ''nulla'':22 ''placerat'':20 ''platea'':4 ''pretium'':10 ''sapien'':19 ''velit'':8 ''vestibulum'':7');
INSERT INTO post VALUES (8, 'parturient montes nascetur ridiculus mus etiam', 13, 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem. Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.', 2006, '2018-03-22 11:16:36.111183+00', NULL, NULL, 30, 14, 13, 'Too High', 'Free', 'Hostile', 'Tough', '''etiam'':6 ''mont'':2 ''mus'':5 ''nascetur'':3 ''parturi'':1 ''ridiculus'':4', '''aliquam'':11 ''ant'':23 ''augu'':12 ''blandit'':27 ''commodo'':35 ''consectetu'':16 ''curabitur'':1 ''dictumst'':10 ''eget'':17 ''erat'':29 ''gravida'':2 ''habitass'':8 ''hac'':7 ''integ'':21 ''ipsum'':25 ''lacinia'':28 ''lorem'':20 ''magna'':32 ''nibh'':5 ''nisi'':3 ''nunc'':34 ''placerat'':36 ''platea'':9 ''praesent'':26 ''quam'':13 ''rutrum'':18 ''sed'':31 ''sollicitudin'':14 ''tincidunt'':22 ''vel'':24 ''vestibulum'':30 ''vita'':15');
INSERT INTO post VALUES (9, 'non mattis pulvinar nulla pede ullamcorper augue a suscipit nulla elit ac nulla sed vel enim', 27, 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi. Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', 2004, '2018-03-22 11:16:36.111183+00', NULL, NULL, 24, 20, 11, 'Very Accessible', 'Accessible', 'Friendly', 'Medium', '''ac'':12 ''augu'':7 ''elit'':11 ''enim'':16 ''matti'':2 ''non'':1 ''nulla'':4,10,13 ''pede'':5 ''pulvinar'':3 ''sed'':14 ''suscipit'':9 ''ullamcorp'':6 ''vel'':15', '''cras'':12 ''eget'':27 ''elementum'':7,29 ''erat'':3 ''ero'':28 ''facilisi'':11 ''id'':4 ''lacus'':21 ''maecena'':19 ''mauri'':5 ''nec'':15 ''nisi'':16 ''non'':13 ''nonummi'':18 ''nulla'':1,10,26 ''nullam'':8 ''pellentesqu'':30 ''tincidunt'':20 ''ut'':2 ''varius'':9 ''vel'':25 ''velit'':14,23 ''vivamus'':24 ''vulput'':6,17');
INSERT INTO post VALUES (10, 'sapien iaculis congue vivamus metus arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget', 17, 'In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.', 2009, '2018-03-22 11:16:36.111183+00', NULL, NULL, 10, 18, 8, 'High', 'Accessible', 'Unfriendly', 'Medium', '''adipisc'':7 ''aenean'':14 ''arcu'':6 ''congu'':3 ''eget'':17 ''hendrerit'':9 ''iaculi'':2 ''lectus'':15 ''metus'':5 ''molesti'':8 ''nisl'':13 ''pellentesqu'':16 ''sapien'':1 ''vita'':12 ''vivamus'':4 ''vulput'':11', '''ac'':7 ''aliquet'':12 ''dui'':3,6 ''feugiat'':14 ''fusc'':9 ''lacus'':10 ''lectus'':18 ''nibh'':8 ''nisl'':5 ''non'':15 ''pretium'':16 ''purus'':11 ''qui'':17 ''sagitti'':2 ''vel'':4');
INSERT INTO post VALUES (11, 'nibh in hac habitasse platea dictumst aliquam augue quam sollicitudin vitae consectetuer eget rutrum at lorem integer', 13, 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet. Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui. Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', 2006, '2018-03-22 11:16:36.111183+00', NULL, NULL, 3, 3, 8, 'Too High', 'Cheap', 'Neutral', 'Medium', '''aliquam'':7 ''augu'':8 ''consectetu'':12 ''dictumst'':6 ''eget'':13 ''habitass'':4 ''hac'':3 ''integ'':17 ''lorem'':16 ''nibh'':1 ''platea'':5 ''quam'':9 ''rutrum'':14 ''sollicitudin'':10 ''vita'':11', '''ac'':28,44 ''aliquam'':6 ''aliquet'':14 ''ant'':51 ''condimentum'':18 ''consequat'':45 ''cras'':30 ''cubilia'':61 ''cura'':62 ''diam'':29,65 ''dui'':33 ''est'':36,40 ''et'':37,58 ''faucibus'':55 ''id'':11,19 ''ipsum'':52 ''justo'':3,24 ''lacus'':7 ''leo'':16 ''luctus'':20,57 ''maecena'':4,15,34 ''magna'':43 ''mauri'':63 ''metus'':46 ''molesti'':22 ''morbi'':8 ''nec'':21 ''nulla'':12 ''nunc'':49 ''odio'':17 ''orci'':56 ''pede'':27 ''pellentesqu'':25,31 ''pharetra'':42 ''posuer'':60 ''potenti'':69 ''primi'':53 ''quam'':41,67 ''qui'':2,9 ''rhoncus'':5 ''sapien'':47 ''sed'':23 ''semper'':39 ''suspendiss'':68 ''tempus'':38 ''tortor'':10 ''tristiqu'':35 ''ultric'':13,59 ''ut'':48 ''vestibulum'':50 ''vita'':66 ''viverra'':26,64 ''volutpat'':32');
INSERT INTO post VALUES (12, 'elementum nullam varius nulla facilisi cras non velit nec nisi vulputate nonummy maecenas tincidunt lacus', 10, 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.', 2008, '2018-03-22 11:16:36.111183+00', NULL, NULL, 25, 14, 9, 'Medium', 'Almost Free', 'Unfriendly', 'Super Easy', '''cras'':6 ''elementum'':1 ''facilisi'':5 ''lacus'':15 ''maecena'':13 ''nec'':9 ''nisi'':10 ''non'':7 ''nonummi'':12 ''nulla'':4 ''nullam'':2 ''tincidunt'':14 ''varius'':3 ''velit'':8 ''vulput'':11', '''ac'':15 ''amet'':21 ''augu'':10 ''dapibus'':24 ''elit'':14 ''enim'':19 ''lacus'':29 ''libero'':3 ''ligula'':27 ''matti'':5 ''nam'':1 ''non'':4 ''nulla'':7,13,16,25 ''nunc'':22 ''pede'':8 ''pulvinar'':6 ''sed'':17 ''sit'':20 ''suscipit'':12,26 ''ullamcorp'':9 ''ultric'':2 ''vel'':18 ''viverra'':23');
INSERT INTO post VALUES (13, 'sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus vivamus vestibulum sagittis', 14, 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', 2012, '2018-03-22 11:16:36.111183+00', NULL, NULL, 1, 12, 1, 'High', 'High', 'Best People On Earth', 'Accessible', '''dis'':6 ''et'':4 ''magni'':5 ''mont'':8 ''mus'':11 ''nascetur'':9 ''natoqu'':2 ''parturi'':7 ''penatibus'':3 ''ridiculus'':10 ''sagitti'':14 ''socii'':1 ''vestibulum'':13 ''vivamus'':12', '''aenean'':1 ''conval'':9,13 ''donec'':3 ''eget'':6,14 ''eleifend'':15 ''eu'':18 ''fermentum'':2 ''libero'':12 ''luctus'':16 ''massa'':7 ''mauri'':5 ''nequ'':11 ''nibh'':19 ''nulla'':10 ''tempor'':8 ''ultrici'':17 ''ut'':4');
INSERT INTO post VALUES (14, 'nec euismod scelerisque quam turpis adipiscing lorem', 2, 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus. Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 2006, '2018-03-22 11:16:36.111183+00', NULL, NULL, 22, 11, 20, 'Too High', 'Free', 'Friendly', 'Super Easy', '''adipisc'':6 ''euismod'':2 ''lorem'':7 ''nec'':1 ''quam'':4 ''scelerisqu'':3 ''turpi'':5', '''amet'':14 ''congu'':4 ''cras'':30 ''cum'':37,53 ''dis'':43,59 ''eleifend'':15 ''et'':41,57 ''eu'':33 ''lectus'':24 ''libero'':17 ''ligula'':12 ''loborti'':11 ''luctus'':36 ''magna'':34 ''magni'':42,58 ''molesti'':21 ''mont'':45,61 ''mus'':48,64 ''nam'':3 ''nascetur'':46,62 ''natoqu'':39,55 ''nibh'':22 ''nulla'':27 ''nullam'':20 ''orci'':19 ''parturi'':44,60 ''pede'':10,16 ''pellentesqu'':25 ''penatibus'':40,56 ''porta'':7 ''potenti'':29 ''purus'':32 ''quam'':9 ''qui'':18 ''ridiculus'':47,63 ''risus'':5 ''sagitti'':2,51 ''sapien'':52 ''sed'':1 ''semper'':6 ''sit'':13 ''socii'':38,54 ''suspendiss'':28 ''vestibulum'':50 ''vivamus'':49 ''volutpat'':8 ''vulput'':35');
INSERT INTO post VALUES (15, 'et commodo vulputate justo in blandit ultrices', 9, 'Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem. Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.', 2006, '2018-03-22 11:16:36.111183+00', NULL, NULL, 24, 5, 9, 'Too High', 'Almost Free', 'Best People On Earth', 'Tough', '''blandit'':6 ''commodo'':2 ''et'':1 ''justo'':4 ''ultric'':7 ''vulput'':3', '''aliquet'':12 ''amet'':34 ''congu'':24 ''dui'':18 ''eleifend'':35 ''feli'':3 ''fusc'':1 ''lacus'':5 ''laoreet'':9 ''lectus'':44 ''libero'':37 ''ligula'':32 ''loborti'':31 ''mauri'':8 ''molesti'':41 ''morbi'':6 ''nam'':23 ''nibh'':42 ''nisl'':15 ''nullam'':40 ''nunc'':16 ''orci'':39 ''pede'':30,36 ''porta'':27 ''posuer'':2 ''pulvinar'':13 ''quam'':29 ''qui'':38 ''rhoncus'':11,17 ''risus'':25 ''sagitti'':22 ''sed'':4,14,21 ''sem'':7,20 ''semper'':26 ''sit'':33 ''ut'':10 ''vel'':19 ''volutpat'':28');
INSERT INTO post VALUES (2, 'erat fermentum justo nec condimentum neque sapien', 2, 'Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis. Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', 1995, '2018-03-22 11:16:36.111183+00', NULL, NULL, 4, 16, 12, 'Too High', 'Cheap', 'Friendly', 'Tough', '''condimentum'':5 ''erat'':1 ''fermentum'':2 ''justo'':3 ''nec'':4 ''nequ'':6 ''sapien'':7', '''accumsan'':26 ''ant'':10,12 ''blandit'':6 ''consequat'':31 ''conval'':29 ''cubilia'':22 ''cura'':23 ''curabitur'':28 ''dolor'':39 ''donec'':37 ''dui'':24,30,32 ''eleifend'':36 ''et'':19 ''faucibus'':16,25 ''fringilla'':45 ''interdum'':8 ''ipsum'':13 ''lectus'':42 ''luctus'':18 ''morbi'':40 ''nec'':33 ''nisi'':34 ''non'':7 ''odio'':27 ''orci'':17 ''posuer'':21 ''primi'':14 ''quam'':2,44 ''rhoncus'':46 ''sapien'':3 ''ultric'':20 ''ut'':5,38 ''varius'':4 ''vel'':41 ''vestibulum'':1,11 ''volutpat'':35');


--
-- Name: post_from_faculty_id_seq; Type: SEQUENCE SET; Schema: public; Owner: lbaw1721
--

SELECT pg_catalog.setval('post_from_faculty_id_seq', 1, false);


--
-- Name: post_id_seq; Type: SEQUENCE SET; Schema: public; Owner: lbaw1721
--

SELECT pg_catalog.setval('post_id_seq', 1, true);


--
-- Data for Name: university; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO university VALUES (1, 'Universidade do Porto', '', 1);
INSERT INTO university VALUES (2, 'University of Sheffield', '', 2);
INSERT INTO university VALUES (3, 'Madelena', 'mandresser0@hostgator.com', 8);
INSERT INTO university VALUES (4, 'Baxie', 'birlam1@upenn.edu', 10);
INSERT INTO university VALUES (5, 'Modestia', 'mroglieri2@newsvine.com', 9);
INSERT INTO university VALUES (6, 'Lucille', 'lclink3@linkedin.com', 2);
INSERT INTO university VALUES (7, 'Lindsey', 'lstaneland4@apple.com', 1);
INSERT INTO university VALUES (8, 'Ahmad', 'acoate5@upenn.edu', 1);
INSERT INTO university VALUES (9, 'Emery', 'eharsnep6@cargocollective.com', 5);
INSERT INTO university VALUES (10, 'Bastian', 'bcleevely7@theguardian.com', 6);
INSERT INTO university VALUES (11, 'Pepe', 'pedmeades8@auda.org.au', 5);
INSERT INTO university VALUES (12, 'Chico', 'crickett9@bbb.org', 2);
INSERT INTO university VALUES (13, 'Dorothy', 'dkocha@uiuc.edu', 10);
INSERT INTO university VALUES (14, 'Steffane', 'smenaulb@domainmarket.com', 8);
INSERT INTO university VALUES (15, 'Magdalene', 'mmurriganc@edublogs.org', 8);
INSERT INTO university VALUES (16, 'Leila', 'lmottersheadd@timesonline.co.uk', 2);
INSERT INTO university VALUES (17, 'Dollie', 'dbindone@answers.com', 5);


--
-- Name: university_id_seq; Type: SEQUENCE SET; Schema: public; Owner: lbaw1721
--

SELECT pg_catalog.setval('university_id_seq', 17, true);


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO "user" VALUES (2, 'vecto@dannyps.net', 'Dannyps', '2018-03-22', 'mypassword', 'Daniel Silva', '2018-03-22 11:16:07.159934+00', '', NULL, 'active');
INSERT INTO "user" VALUES (4, 'jlopes@fe.up.pt', 'jcl', '2018-03-22', '$2y$10$e.cV4dOdlHNKfCzs68m0B.XULEeUk5yuR8CCdzL2ZqAAuz1cY0hpq', '', '2018-03-22 16:33:10.67649+00', '', '2018-03-27 11:00:00+01', 'active');
INSERT INTO "user" VALUES (5, 'bb@bb.com', 'putin', '2018-03-22', '$2y$10$Do.RgVkvfuGnWzszpCL4Gulsl8dQvNukGZDWoiCtuByDRijkvLugG', '', '2018-03-22 16:33:10.67649+00', '', '2018-03-27 11:00:00+01', 'active');
INSERT INTO "user" VALUES (6, 'cc@cc.com', 'trump', '2018-03-22', '$2y$10$rBhdJkkS13eL7XoQVGL4W.TBRM/QGD0b5FrQe9A1jZLQWu2adhb3m', '', '2018-03-22 16:33:10.67649+00', '', '2018-03-27 11:00:00+01', 'active');
INSERT INTO "user" VALUES (8, 'ee@ee.com', 'marcelo', '2018-03-22', '$2y$10$NXbx/ZftuJf/KwntPQfEU.F7doPfX5iKxf7/dbcnL2ATtg.R37tsa', '', '2018-03-22 16:33:10.67649+00', '', '2018-03-27 11:00:00+01', 'active');
INSERT INTO "user" VALUES (9, 'arestivo@fe.up.pt', 'arestivo', '2018-03-22', '$2y$10$ZB8q7BZ7WwzAXLYV6qbk4ue3yvbdadSJlS/WFbouLZZDEborWUmPS', '', '2018-03-22 16:33:10.67649+00', '', '2018-03-27 11:00:00+01', 'active');
INSERT INTO "user" VALUES (10, 'obama@white.house.com', 'obama', '2018-03-22', '$2y$10$saMOolU1lbqFsqlJZ.jTxOHkoEpRtZTC7iuKMU2N.pvBPaSdzVz1e', '', '2018-03-22 16:33:10.67649+00', '', '2018-03-27 11:00:00+01', 'active');
INSERT INTO "user" VALUES (11, 'aramos@fe.up.pt', 'aramos', '2018-03-22', '$2y$10$jbZ8RFkjbcy784dqBrEwiOG7FNl6Lg/Uv9NNYr79wf4NpSISpDZf.', '', '2018-03-22 16:33:10.67649+00', '', '2018-03-27 11:00:00+01', 'active');
INSERT INTO "user" VALUES (12, 'msramalho@fe.up.pt', 'msramalho', '2018-03-22', '$2y$10$TpcoZ9/xAMruOcsrefDJ4OPT9/wHW7TnrNlER6N0Nk5R8qxVRxq16', '', '2018-03-22 16:33:10.67649+00', '', '2018-03-27 11:00:00+01', 'active');
INSERT INTO "user" VALUES (7, 'dd@dd.co', 'acosta', '2018-03-22', '$2y$10$xfCI/0uI/xYY1tk9/2DWX.FzcUayIZeucuQ.kIqVyBrReVEGfVGYi', '', '2018-03-22 16:33:10.67649+00', '', '2018-03-27 11:00:00+01', 'active');
INSERT INTO "user" VALUES (13, 'aavrahm0@vistaprint.com', 'aavrahm0', '2018-03-22', '1KWYxNbXoZ4wxeKTVviejTyoyYZSPEYVjh', 'Annabella Avrahm', '2018-03-22 11:16:36.111183+00', 'Decreased fetal movements, unspecified trimester, fetus 3', NULL, 'active');
INSERT INTO "user" VALUES (15, 'bgiorgioni1@about.me', 'bgiorgioni1', '2018-03-22', '1FhDGAyHvEyoEDD8DvXSArpV4Doud3J5Qj', 'Broddie Giorgioni', '2018-03-22 11:16:36.111183+00', 'Motorcycle passenger injured in collision with pedestrian or animal in nontraffic accident', NULL, 'active');
INSERT INTO "user" VALUES (16, 'apanks2@jigsy.com', 'apanks2', '2018-03-22', '1NisuEkTYnQH6pvm6YE5RbxpfbF7JJ82x7', 'Anton Panks', '2018-03-22 11:16:36.111183+00', 'Unspecified balloon accident injuring occupant', NULL, 'banned');
INSERT INTO "user" VALUES (17, 'dmatyatin3@google.com.br', 'dmatyatin3', '2018-03-22', '1K2NT9iZ7LnDDei5Dbm7XT9Z3L6bHqVPFj', 'Dian Matyatin', '2018-03-22 11:16:36.111183+00', 'Displaced unspecified condyle fracture of lower end of right femur, subsequent encounter for closed fracture with routine healing', NULL, 'active');
INSERT INTO "user" VALUES (18, 'mbullin4@liveinternet.ru', 'mbullin4', '2018-03-22', '1MwQBTE5yZffoNCHfEnkADzrpzqJuVSjzk', 'Malvina Bullin', '2018-03-22 11:16:36.111183+00', 'Malignant carcinoid tumor of the transverse colon', NULL, 'active');
INSERT INTO "user" VALUES (19, 'kbalderston5@smugmug.com', 'kbalderston5', '2018-03-22', '1HaS94fMSDSnY4KCzXVC92iE912sQvLgUv', 'Klement Balderston', '2018-03-22 11:16:36.111183+00', 'Occupant of animal-drawn vehicle injured in collision with other animal-drawn vehicle', NULL, 'active');
INSERT INTO "user" VALUES (20, 'swinsom6@gmpg.org', 'swinsom6', '2018-03-22', '1GZXQTaXSdM3v99vA6Bx4SpcKAXgVs8bxx', 'Simmonds Winsom', '2018-03-22 11:16:36.111183+00', 'Other hang-glider accident injuring occupant', NULL, 'active');
INSERT INTO "user" VALUES (21, 'abirckmann7@nyu.edu', 'abirckmann7', '2018-03-22', '1PGUCjB4rMH29H8MJGP5MJTembgVpk9tJT', 'Ashlie Birckmann', '2018-03-22 11:16:36.111183+00', 'Candidiasis of skin and nail', NULL, 'active');
INSERT INTO "user" VALUES (22, 'lleverton8@sogou.com', 'lleverton8', '2018-03-22', '153JtWhmnVTp6DVcfQ5g7v9AHVDe7KMufi', 'Lucho Leverton', '2018-03-22 11:16:36.111183+00', 'Disproportion of reconstructed breast', NULL, 'active');
INSERT INTO "user" VALUES (23, 'imc9@privacy.gov.au', 'imc9', '2018-03-22', '1GezVUHiKoJRwnPhn4kyd1ehZG4thSMUjD', 'Isaiah Mc Queen', '2018-03-22 11:16:36.111183+00', 'Other injury of heart with hemopericardium, subsequent encounter', NULL, 'active');
INSERT INTO "user" VALUES (24, 'spetrova@networkadvertising.org', 'spetrova', '2018-03-22', '1ewrTL9Fy7ZQnT1XhpzUsR2EjYVXbRxup', 'Simon Petrov', '2018-03-22 11:16:36.111183+00', 'Displaced fracture of neck of right radius, subsequent encounter for open fracture type IIIA, IIIB, or IIIC with routine healing', NULL, 'active');
INSERT INTO "user" VALUES (25, 'fskamellb@upenn.edu', 'fskamellb', '2018-03-22', '1AKxqEHzJ63F3KUaE5TQSLjnv8EJrPPCKZ', 'Fernandina Skamell', '2018-03-22 11:16:36.111183+00', 'Hemopericardium as current complication following acute myocardial infarction', NULL, 'active');
INSERT INTO "user" VALUES (26, 'ibrayshayc@naver.com', 'ibrayshayc', '2018-03-22', '1Lw9okg3FzuhSd5sm9BppD6dKyBfPGBZjv', 'Itch Brayshay', '2018-03-22 11:16:36.111183+00', 'Laceration of superficial palmar arch of right hand, initial encounter', NULL, 'active');
INSERT INTO "user" VALUES (27, 'omauchlined@independent.co.uk', 'omauchlined', '2018-03-22', '134VFRP2Vz7D1ZjYDDJHZRD53pBNcFyc1U', 'Oona Mauchline', '2018-03-22 11:16:36.111183+00', 'Toxic effect of contact with other venomous fish, accidental (unintentional), initial encounter', NULL, 'active');
INSERT INTO "user" VALUES (28, 'hkendelle@surveymonkey.com', 'hkendelle', '2018-03-22', '16wQ8A8uQES4YyG2VSfHETmXD6fDrLhiX5', 'Hersh Kendell', '2018-03-22 11:16:36.111183+00', 'Burn of first degree of shoulder and upper limb, except wrist and hand, unspecified site, subsequent encounter', NULL, 'admin');
INSERT INTO "user" VALUES (29, 'jthiemef@marriott.com', 'jthiemef', '2018-03-22', '1Hkc9K3GMbv1fCWeUzCzjPmYk6js4A8MTY', 'Junette Thieme', '2018-03-22 11:16:36.111183+00', 'Personal history of malignant neoplasm of thyroid', NULL, 'active');
INSERT INTO "user" VALUES (30, 'gscareg@usda.gov', 'gscareg', '2018-03-22', '1LrpE7gTSL7UastHaTuvhN2hePFDDXWaVa', 'Garrek Scare', '2018-03-22 11:16:36.111183+00', 'Acute eczematoid otitis externa, right ear', NULL, 'banned');
INSERT INTO "user" VALUES (31, 'sivashechkinh@sourceforge.net', 'sivashechkinh', '2018-03-22', '1EbVnA79QzKCk73n8FBjVVbVQp7ofGvuiD', 'Stephenie Ivashechkin', '2018-03-22 11:16:36.111183+00', 'Injury of radial nerve at upper arm level, left arm, subsequent encounter', NULL, 'active');
INSERT INTO "user" VALUES (32, 'eseversi@nhs.uk', 'eseversi', '2018-03-22', '1CKST64UrNq9ZLbYzMJXEctcjT3mGmRMEn', 'Estel Severs', '2018-03-22 11:16:36.111183+00', 'Encounter for initial prescription of vaginal ring hormonal contraceptive', NULL, 'active');
INSERT INTO "user" VALUES (36, 'sfarmarm@miitbeian.gov.cn', 'sfarmarm', '2018-03-22', '1BqNSxNmoTxje6gNJT1qgEyyaBs3DpMahC', 'Seward Farmar', '2018-03-22 11:16:36.111183+00', 'Aneurysmal bone cyst', NULL, 'active');
INSERT INTO "user" VALUES (37, 'bsaizn@biblegateway.com', 'bsaizn', '2018-03-22', '12DYK9shjrKmsj9PHtmLiLoJQG5b4McDv7', 'Bili Saiz', '2018-03-22 11:16:36.111183+00', 'Pathological fracture in neoplastic disease, right foot, subsequent encounter for fracture with routine healing', NULL, 'active');
INSERT INTO "user" VALUES (38, 'agowrieo@mediafire.com', 'agowrieo', '2018-03-22', '12VKGyy4QSEo68Z7Akmr6E5wNXJRTox9wU', 'Abby Gowrie', '2018-03-22 11:16:36.111183+00', 'Displaced Maisonneuve''s fracture of unspecified leg, subsequent encounter for closed fracture with routine healing', NULL, 'active');
INSERT INTO "user" VALUES (39, 'jkendredp@rambler.ru', 'jkendredp', '2018-03-22', '12HFxevVcxRCdEF8sVRgpYU52Dvcttt2NR', 'Janith Kendred', '2018-03-22 11:16:36.111183+00', 'Adverse effect of saline and osmotic laxatives', NULL, 'active');
INSERT INTO "user" VALUES (40, 'mcapelleq@tripadvisor.com', 'mcapelleq', '2018-03-22', '16kPRPFE6CB5CFXRTDTcgcJuDWPzrwB7W6', 'Mord Capelle', '2018-03-22 11:16:36.111183+00', 'Nondisplaced transverse fracture of shaft of right fibula, subsequent encounter for open fracture type I or II with nonunion', NULL, 'banned');
INSERT INTO "user" VALUES (41, 'kdavissonr@networksolutions.com', 'kdavissonr', '2018-03-22', '1FqxiBLaAEgmSzU2Enm8ET26NsAbjbyySf', 'Katerina Davisson', '2018-03-22 11:16:36.111183+00', 'Burn of unspecified degree of right scapular region, sequela', NULL, 'active');
INSERT INTO "user" VALUES (42, 'hmansers@cpanel.net', 'hmansers', '2018-03-22', '1MJt5cbRegPeZ8LFPVvraaZ39VxstmbRRN', 'Hedi Manser', '2018-03-22 11:16:36.111183+00', 'Pneumonia due to staphylococcus, unspecified', NULL, 'banned');
INSERT INTO "user" VALUES (43, 'mcominottit@example.com', 'mcominottit', '2018-03-22', '1wibWX46UH7AFxSPDuBUXmr83bdiJFv85', 'Marmaduke Cominotti', '2018-03-22 11:16:36.111183+00', 'Minor laceration of vertebral artery', NULL, 'active');
INSERT INTO "user" VALUES (3, 'ajuettj@abc.net.au', 'ajuettj', '2018-03-22', '1Ks2xfaDhWStPr2kKb4rYseipYHaovVpwh', 'Artus Juett', '2018-03-22 11:16:36.111183+00', 'Labor and delivery complicated by other cord entanglement, with compression, fetus 2', NULL, 'active');
INSERT INTO "user" VALUES (14, 'afindenk@phoca.cz', 'afindenk', '2018-03-22', '1Ks9a7QeQmn572Nr2mvKfEf4ubzxM4xBuh', 'Addie Finden', '2018-03-22 11:16:36.111183+00', 'Activities involving ice and snow', NULL, 'active');
INSERT INTO "user" VALUES (1, 'pbirkl@disqus.com', 'pbirkl', '2018-03-22', '1G3TZheGQZx2hRv42jC4VSpC6uNGBWzem5', 'Penelope Birk', '2018-03-22 11:16:36.111183+00', 'Postprocedural subglottic stenosis', NULL, 'active');


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: lbaw1721
--

SELECT pg_catalog.setval('user_id_seq', 43, true);


--
-- Data for Name: vote; Type: TABLE DATA; Schema: public; Owner: lbaw1721
--

INSERT INTO vote VALUES (29, 2);
INSERT INTO vote VALUES (6, 6);
INSERT INTO vote VALUES (9, 3);
INSERT INTO vote VALUES (24, 8);
INSERT INTO vote VALUES (29, 11);
INSERT INTO vote VALUES (21, 13);
INSERT INTO vote VALUES (8, 13);
INSERT INTO vote VALUES (16, 12);
INSERT INTO vote VALUES (6, 7);
INSERT INTO vote VALUES (3, 13);
INSERT INTO vote VALUES (18, 14);
INSERT INTO vote VALUES (9, 10);
INSERT INTO vote VALUES (7, 11);
INSERT INTO vote VALUES (16, 6);
INSERT INTO vote VALUES (5, 5);
INSERT INTO vote VALUES (6, 2);


--
-- Name: city_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY city
    ADD CONSTRAINT city_pkey PRIMARY KEY (id);


--
-- Name: comment_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY comment
    ADD CONSTRAINT comment_pkey PRIMARY KEY (id);


--
-- Name: country_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pkey PRIMARY KEY (id);


--
-- Name: faculty_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY faculty
    ADD CONSTRAINT faculty_pkey PRIMARY KEY (id);


--
-- Name: flag_comment_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY flag_comment
    ADD CONSTRAINT flag_comment_pkey PRIMARY KEY (flagger_id, comment_id);


--
-- Name: flag_post_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY flag_post
    ADD CONSTRAINT flag_post_pkey PRIMARY KEY (flagger_id, post_id);


--
-- Name: flag_user_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY flag_user
    ADD CONSTRAINT flag_user_pkey PRIMARY KEY (flagger_id, flagged_id);


--
-- Name: following_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY following
    ADD CONSTRAINT following_pkey PRIMARY KEY (follower_id, followed_id);


--
-- Name: post_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY post
    ADD CONSTRAINT post_pkey PRIMARY KEY (id);


--
-- Name: university_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY university
    ADD CONSTRAINT university_pkey PRIMARY KEY (id);


--
-- Name: user_email_key; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_email_key UNIQUE (email);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: user_username_key; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_username_key UNIQUE (username);


--
-- Name: vote_pkey; Type: CONSTRAINT; Schema: public; Owner: lbaw1721; Tablespace: 
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT vote_pkey PRIMARY KEY (user_id, post_id);


--
-- Name: comment_post_id; Type: INDEX; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE INDEX comment_post_id ON comment USING btree (post_id);


--
-- Name: post_author; Type: INDEX; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE INDEX post_author ON post USING btree (author_id);


--
-- Name: user_id; Type: INDEX; Schema: public; Owner: lbaw1721; Tablespace: 
--

CREATE INDEX user_id ON "user" USING hash (id);


--
-- Name: max_two_mobilities_per_year; Type: TRIGGER; Schema: public; Owner: lbaw1721
--

CREATE TRIGGER max_two_mobilities_per_year BEFORE INSERT OR UPDATE ON post FOR EACH ROW EXECUTE PROCEDURE max_two_mobilities_per_year();


--
-- Name: post_search_update; Type: TRIGGER; Schema: public; Owner: lbaw1721
--

CREATE TRIGGER post_search_update BEFORE INSERT OR UPDATE ON post FOR EACH ROW EXECUTE PROCEDURE post_search_update();


--
-- Name: update_vote; Type: TRIGGER; Schema: public; Owner: lbaw1721
--

CREATE TRIGGER update_vote AFTER INSERT OR UPDATE ON vote FOR EACH ROW EXECUTE PROCEDURE update_vote();


--
-- Name: user_prevent_self_flag_comment; Type: TRIGGER; Schema: public; Owner: lbaw1721
--

CREATE TRIGGER user_prevent_self_flag_comment BEFORE INSERT OR UPDATE ON flag_comment FOR EACH ROW EXECUTE PROCEDURE user_prevent_self_flag_comment();


--
-- Name: vote_prevent_own_user; Type: TRIGGER; Schema: public; Owner: lbaw1721
--

CREATE TRIGGER vote_prevent_own_user BEFORE INSERT OR UPDATE ON vote FOR EACH ROW EXECUTE PROCEDURE vote_prevent_own_user();


--
-- Name: city_country_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY city
    ADD CONSTRAINT city_country_id_fkey FOREIGN KEY (country_id) REFERENCES country(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: comment_author_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY comment
    ADD CONSTRAINT comment_author_id_fkey FOREIGN KEY (author_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: comment_post_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY comment
    ADD CONSTRAINT comment_post_id_fkey FOREIGN KEY (post_id) REFERENCES post(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: faculty_city_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY faculty
    ADD CONSTRAINT faculty_city_id_fkey FOREIGN KEY (city_id) REFERENCES city(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: faculty_university_id_key; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY faculty
    ADD CONSTRAINT faculty_university_id_key FOREIGN KEY (university_id) REFERENCES university(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: flag_comment_comment_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY flag_comment
    ADD CONSTRAINT flag_comment_comment_id_fkey FOREIGN KEY (comment_id) REFERENCES comment(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: flag_comment_flagger_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY flag_comment
    ADD CONSTRAINT flag_comment_flagger_id_fkey FOREIGN KEY (flagger_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: flag_post_flagger_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY flag_post
    ADD CONSTRAINT flag_post_flagger_id_fkey FOREIGN KEY (flagger_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: flag_post_post_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY flag_post
    ADD CONSTRAINT flag_post_post_id_fkey FOREIGN KEY (post_id) REFERENCES post(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: flag_user_flagged_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY flag_user
    ADD CONSTRAINT flag_user_flagged_id_fkey FOREIGN KEY (flagged_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: flag_user_flagger_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY flag_user
    ADD CONSTRAINT flag_user_flagger_id_fkey FOREIGN KEY (flagger_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: following_followed_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY following
    ADD CONSTRAINT following_followed_id_fkey FOREIGN KEY (followed_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: following_follower_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY following
    ADD CONSTRAINT following_follower_id_fkey FOREIGN KEY (follower_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: post_author_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY post
    ADD CONSTRAINT post_author_id_fkey FOREIGN KEY (author_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: post_from_faculty_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY post
    ADD CONSTRAINT post_from_faculty_id_fkey FOREIGN KEY (from_faculty_id) REFERENCES faculty(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: post_to_faculty_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY post
    ADD CONSTRAINT post_to_faculty_id_fkey FOREIGN KEY (to_faculty_id) REFERENCES faculty(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: university_country_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY university
    ADD CONSTRAINT university_country_id_fkey FOREIGN KEY (country_id) REFERENCES country(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: vote_post_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT vote_post_id_fkey FOREIGN KEY (post_id) REFERENCES post(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: vote_user_id_fkey1; Type: FK CONSTRAINT; Schema: public; Owner: lbaw1721
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT vote_user_id_fkey1 FOREIGN KEY (user_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: lbaw1721
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM lbaw1721;
GRANT ALL ON SCHEMA public TO lbaw1721;


--
-- PostgreSQL database dump complete
--

