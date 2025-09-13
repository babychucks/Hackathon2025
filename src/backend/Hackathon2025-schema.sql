SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


Drop schema if exists `Hackathon2025`;
create schema if not exists `Hackathon2025` default character set latin1;
use `Hackathon2025`;

create table if not exists `Hackathon2025`.`Users`(
    `id` INT(13) not null Primary Key,
    `name` varchar(20) not null,
    `surname` varchar(30) not null,
    `D.O.B` DATE not null,
    `email` varchar(60) not null,
    `password` varchar(20) not null,
    `salt` char(12) not null,
    `api_key` char(64) not null
    
);

create table if not exists `Hackathon2025`.`Transactions`(
    `id` INT(13) not null,
    `transaction_id` char(8) not null Primary Key,
    `transaction_type` enum('income', 'expense'),
    -- `category` char(20) not null,
    `transaction_amount` Decimal(12) default 0,
    `current_budget` decimal(12),

    -- constraint `fk_trans_income`
    --     foreign key(`category`)
    constraint `fk_trans_user`
        foreign key (`id`)
        references `Hackathon2025`.`Users`(`id`)
        on delete no action
        on update no action
);

create table if not exists `Hackathon2025`.`Income_Category`(
    `id` int(8) not null auto_increment Primary Key ,
    `category_name` varchar(20) not null,
    `category_budget` Decimal(12)
);

create table if not exists `Hackathon2025`.`Expense_Category`(
    `id` int(8) not null auto_increment Primary Key ,
    `category_name` varchar(20) not null,
    `category_budget` Decimal(12)
);

create table if not exists `Hackathon2025`. `Points`(
    `point_id` int(5) not null Primary Key,
    `point_num` int(3) not null,
    `tier` enum('1', '2', '3', '4')
);


create table if not exists `Hackathon2025`.`User_Points`(
    `user_id` INT(13) not null,
    `point_id` int(5) not null,
    `user_tier` int(1) not null,

    Primary Key(`user_id`, `point_id`),

    constraint `fk_user_points`
        foreign key (`user_id`)
        references `Hackathon2025`.`Users`(`id`)
        on delete no action
        on update no action,

    constraint `fk_userpoints_points`
        foreign key (`point_id`)
        references `Hackathon2025`. `Points`(`point_id`)
        on delete no action
        on update no action
);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;