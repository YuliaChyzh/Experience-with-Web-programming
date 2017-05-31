-- Usersdb clear

truncate user_db.user_system;
delete from user_db.users where id > 0;	
alter table user_db.users auto_increment = 1;

-- Usersdb insert

insert into user_db.users values (1, 'Ivan Ivanov','+380665544259', 'vanek@gmail.com', 14 ),
    (2, 'Petro Petrow','+380664658465', 'petya@gmail.com', 15 ),
    (3, 'Sergey Sergeew','+380666548465', 'seruy@gmail.com', 16 ),
    (4, 'Vladimir Vladimirov','+380661321548', 'volodya@gmail.com', 17 );
    
insert into user_db.user_system values (1, 'Chrome', '77.47.218.81', now() ),
    (2, 'Safari', '77.47.218.82', now()),
    (3, 'Mozilla', '77.47.218.83', now()),
    (4, 'Chrome', '77.47.218.84', now());
    
-- Usersdb select
select * from user_db.users;
select * from user_db.user_system;


select user_db.users.id, 
		name, 
		phone,
		email,
		hour,
		ip,
		brouser,
		time
    from user_db.users
	inner join user_db.user_system on (user_db.user_system.user = user_db.users.id)