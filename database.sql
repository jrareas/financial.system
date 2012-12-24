create table companies(id integer auto_increment primary key
,name varchar(200));


insert into companies values('Personal_JRAREAS');
drop table users;
create table users(id integer auto_increment primary key
,user_id varchar(200) not null unique 
,user_first_name varchar(150)
,user_last_name varchar(150)
,email varchar(200)
,user_password varchar(200)
,last_login timestamp);

alter table users 
add column new_password_code_request varchar(100) unique;
alter table users 
add column new_password varchar(100);
update users set user_password = '3ee32956a887a53ffaa378b3e6633fa663088da3' where id=1;
select * from users;
insert into users (user_id,user_first_name,user_last_name,email,user_password)
value('admin','Admin','User','jrareas@gmail.com','3ee32956a887a53ffaa378b3e6633fa663088da3');

insert into menus(parent_menu,menu_display,menu_link,menu_order)
values(null,'Dash Board','/dashboard',1);
insert into menus(parent_menu,menu_display,menu_link,menu_order)
values(null,'Account','/account',2);
insert into menus(parent_menu,menu_display,menu_link,menu_order)
values(2,'New Account','/account',1);
insert into menus(parent_menu,menu_display,menu_link,menu_order)
values(null,'Log Off','/login/logoff',50);

select * from menu order by parent_menu,menu_order;
drop table menus;
create table `menus`(id integer auto_increment primary key
,parent_menu integer null
,menu_display varchar(20)
,menu_link varchar(20)
,menu_order integer
,lft integer
,rgt integer
,constraint fk_parent_menu foreign key(parent_menu)references menus(id));
select * from files;
insert into files (file_name,user_id)values('Personal budget',1);
insert into files (file_name,user_id)values('Company budget',1);
select * from files;
create table files(id integer auto_increment primary key
,file_name varchar(60)
,user_id integer 
,constraint foreign key fk_file_user_id(user_id) references users(id));
alter table files
ADD column default_file tinyint not null default 0;

alter table files drop column defaul_file;