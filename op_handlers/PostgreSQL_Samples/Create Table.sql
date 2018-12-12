CREATE TABLE op.tabs
(
  tabs_id integer,
  tabs text,
  tabs_order integer,
  appname text
)
WITH (
  OIDS=FALSE
);
ALTER TABLE op.tabs
  OWNER TO geodata;
GRANT ALL ON TABLE op.tabs TO geodata;
GRANT SELECT ON TABLE op.tabs TO read_geodata;


CREATE TABLE op.items
(
  items_id integer,
  items text,
  url text,
  items_order integer,
  content text,
  tabs_id integer
)
WITH (
  OIDS=FALSE
);
ALTER TABLE op.items
  OWNER TO geodata;
GRANT ALL ON TABLE op.items TO geodata;
GRANT SELECT ON TABLE op.items TO read_geodata;


CREATE TABLE op.tabs_test
(
  tabs_id serial NOT NULL,
  tabs text,
  tabs_order integer,
  appname text,
  CONSTRAINT test_tabs_id_scroll_pky PRIMARY KEY (tabs_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE op.tabs_test
  OWNER TO geodata;
GRANT ALL ON TABLE op.tabs_test TO geodata;
GRANT SELECT ON TABLE op.tabs_test TO read_geodata;
GRANT ALL ON TABLE op.tabs_test TO edit_gronplan;



CREATE TABLE op.items_test
(
  items_id serial NOT NULL,
  items text,
  url text,
  items_order integer,
  content text,
  tabs_id integer,
  CONSTRAINT test_items_id_scroll_pky PRIMARY KEY (items_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE op.items_test
  OWNER TO geodata;
GRANT ALL ON TABLE op.items_test TO geodata;
GRANT SELECT ON TABLE op.items_test TO read_geodata;
GRANT ALL ON TABLE op.items_test TO edit_gronplan;

