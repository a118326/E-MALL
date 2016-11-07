<?php 
  require_once 'db_connect.php';

 createTable ('buyers',
              'user varchar(32) primary key unique,
		password varchar(32),
		firstname varchar(32),
		lastname varchar(32),
		address varchar(50),
		creditcard varchar(50)');

  createTable('items',
              'itemid int unsigned primary key unique,
		itemname varchar(32),
		price real');

  createTable('buy', 
              'transaction_num int unsigned primary key,
		itemid int unsigned NOT NULL,
		user varchar(32) NOT NULL,
		total_price real,
		qty int unsigned,
		sell_date time,
		ptime time,
		FOREIGN KEY (user)
     			 REFERENCES buyers(user),
		FOREIGN KEY (itemid)
     			 REFERENCES buyers(itemid)	');

?>