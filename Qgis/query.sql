create extension postgis
CREATE EXTENSION pgrouting;
alter table dongda_street add column source integer;
alter table dongda_street add column target integer;
select * from dongda_street

select pgr_createTopology('dongda_street', 0.0001, 'geom', 'gid');


SELECT seq, id1 AS node, id2 AS edge, cost, geom
FROM pgr_dijkstra(
'SELECT gid as id, source, target, st_length(geom) as cost FROM dongda_street',
1, 3000, false, false
) as di
JOIN dongda_street pt
ON di.id2 = pt.gid ;



CREATE OR REPLACE FUNCTION pgr_fromAtoB(
IN tbl varchar,
IN x1 double precision,
IN y1 double precision,
IN x2 double precision,
IN y2 double precision,
OUT seq integer,
OUT gid integer,
OUT name text,
OUT heading double precision,
OUT cost double precision,
OUT geom geometry
)
RETURNS SETOF record AS
$BODY$
DECLARE
sql text;
rec record;
source integer;
target integer;
point integer;
BEGIN
-- Find nearest node
EXECUTE 'SELECT id::integer FROM split_vertices_pgr
ORDER BY the_geom <-> ST_GeometryFromText(''POINT('
|| x1 || ' ' || y1 || ')'',4326) LIMIT 1' INTO rec;
source := rec.id;
EXECUTE 'SELECT id::integer FROM split_vertices_pgr
ORDER BY the_geom <-> ST_GeometryFromText(''POINT('
|| x2 || ' ' || y2 || ')'',4326) LIMIT 1' INTO rec;
target := rec.id;
-- Shortest path query (TODO: limit extent by BBOX)
seq := 0;
sql := 'SELECT gid as id, geom, name, cost, source, target,
ST_Reverse(geom) AS flip_geom FROM ' ||
'pgr_dijkstra(''SELECT gid as id , source::int, target::int, '
|| 'st_length(geom) as cost FROM '
|| quote_ident(tbl) || ''', '
|| source || ', ' || target
|| ' , false, false), '
|| quote_ident(tbl) || ' WHERE id2 = gid ORDER BY seq';
-- Remember start point
point := source;
FOR rec IN EXECUTE sql
LOOP
-- Flip geometry (if required)
IF ( point != rec.source ) THEN
rec.geom := rec.flip_geom;
point := rec.source;
ELSE
point := rec.target;
END IF;
-- Calculate heading (simplified)
EXECUTE 'SELECT degrees( ST_Azimuth(
ST_StartPoint(''' || rec.geom::text || '''),
ST_EndPoint(''' || rec.geom::text || ''') ) )'
INTO heading;
-- Return record
seq := seq + 1;
gid := rec.id;
name := rec.name;
cost := rec.cost;
geom := rec.geom;
RETURN NEXT;
END LOOP;
RETURN;
END;
$BODY$
LANGUAGE 'plpgsql' VOLATILE STRICT;


SELECT (route.geom) FROM (
SELECT geom FROM pgr_fromAtoB('dongda_street', 0, 0, -1, -1
) ORDER BY seq) AS route

select * from dongda_univercity as a, dongda_univercity_point as b where a.osm_id = b.osm_id