CREATE TABLE `b44987_winter`.`qdm_battles` (
`id` INT NOT NULL AUTO_INCREMENT COMMENT 'id of battle',
`player_id` INT NOT NULL COMMENT 'first plaer id',
`opponent_id` INT NOT NULL COMMENT 'second player id',
`date` INT NOT NULL COMMENT 'date',
`log` TEXT NOT NULL COMMENT 'log',
PRIMARY KEY ( `id` )
) ENGINE = MYISAM COMMENT = 'battle info';
