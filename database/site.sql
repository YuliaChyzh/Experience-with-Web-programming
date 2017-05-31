-- sitestructure clear
truncate site_db.metatag;
truncate site_db.page_description;
delete from site_db.page where id > 0;	
alter table site_db.page auto_increment = 1;

truncate site_db.subgallery;
delete from site_db.photo where id > 0;	
alter table site_db.photo auto_increment = 1;
delete from site_db.gallery where id > 0;	
alter table site_db.gallery auto_increment = 1;

-- page insert
insert into site_db.page value (1, 'home page', 'https://photogallery.com.ua', now()),
	(2, 'table page', 'https://photogallery.com.ua/table', now()),
    (3, 'cards', 'https://photogallery.com.ua/cards', now());

-- metatag insert
insert into site_db.metatag values (1, 'keywords', 'gallery', now(), 1),
	(2, 'description', 'gallery description', now(), 1),
    (3, 'keywords', 'subgallery 1', now(), 2),
    (4, 'description', 'subgallery 1 description', now(), 2),
    (5, 'keywords', 'subgallery 2', now(), 3),
    (6, 'description', 'subgallery 2 description', now(), 3);

-- pagedescription insert
insert into site_db.page_description values (1, 'page 1 text', 1),
	(2, 'page 2 text', 2),
	(3, 'page 3 text', 3);

-- gallery insert
insert into site_db.gallery values (1, 'gallery1', now(), 'yulia'),
	(2, 'gallery2', now(), 'chyzh'),
    (3, 'gallery3', now(), 'anna');

-- photo insert    
insert into site_db.photo values (1, 4.5, 'photo 1'),
	(2, 5.0, 'photo 2'),
    (3, 4.7, 'photo 3');
    
-- subgallery insert
insert into site_db.subgallery values (1,'subgallery 1','subject 1',1, 1), (2,'subgallery 2','subject 2',2, 1), (3,'subgallery 3','subject 3',2, 3);

-- select *
select * from site_db.metatag;
select * from site_db.page_description;
select * from site_db.page;
select * from site_db.photo;
select * from site_db.subgallery;
select * from site_db.gallery;

-- select page info
select site_db.page.id as 'id page', 
		site_db.page.name, 
		url, 
		site_db.page.d_create,
		site_db.metatag.name as 'metatag name',
		description as 'metatag description',
		site_db.metatag.d_create as 'metatag d_create',
		site_db.page_description.text
    from site_db.page 
	inner join site_db.metatag on(site_db.metatag.page = site_db.page.id)
    inner join site_db.page_description on (site_db.page_description.page = site_db.page.id);
    
-- select product info
select site_db.gallery.id as 'gallery id',
		site_db.gallery.name,
		site_db.gallery.date,
		site_db.gallery.autor,
		site_db.photo.name as 'photo name'
    from site_db.gallery
    inner join site_db.photo on (site_db.photo.id in 
				( select site_db.subgallery.photo from site_db.subgallery where 
						( site_db.subgallery.gallery = site_db.gallery.id)));