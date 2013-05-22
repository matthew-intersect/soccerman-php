create database android_api

use android_api 

---
--- Users
---
create table users (
    id int primary key auto_increment,
    name varchar(50) not null,
    email varchar(100) not null unique,
    encrypted_password varchar(80) not null,
    salt varchar(10) not null,
    created_at datetime,
    updated_at datetime null
); 


---
--- Teams
---
create table teams (
    id int primary key auto_increment,
    name varchar(50) not null,
    code varchar(6) not null unique,
    created_by int not null,
    created_at datetime,
    constraint team_created_by_fk foreign key (created_by)
        references users(id)
);


---
--- Team Players
---
create table team_players (
    team_id int not null,
    player_id int not null,
    constraint team_players_pk primary key (team_id, player_id),
    constraint team_id_fk foreign key (team_id)
        references teams(id),
    constraint player_id_fk foreign key (player_id)
        references users(id)
);


---
--- Matches
---
create table matches (
    id int primary key auto_increment,
    team int not null,
    opponent varchar(50) not null,
    home_away varchar(4),
    comp_round int,
    game_time long,
    location varchar(50),
    constraint match_team_fk foreign key (team)
        references teams(id)
);