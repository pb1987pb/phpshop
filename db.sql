create database php39;
use php39;
set names utf8;

drop table if exists p39_goods;
create table p39_goods
(
	id mediumint unsigned not null auto_increment comment 'Id',
	goods_name varchar(150) not null comment '商品名称',
        brand_id mediumint unsigned not null default '0' comment '所属品牌',--品牌可以为空
	market_price decimal(10,2) not null comment '市场价格',
	shop_price decimal(10,2) not null comment '本店价格',
	goods_desc longtext comment '商品描述',
	is_on_sale enum('是','否') not null default '是' comment '是否上架',
	is_delete enum('是','否') not null default '否' comment '是否放到回收站',
	addtime datetime not null comment '添加时间',
	logo varchar(150) not null default '' comment '原图',-- 可以为空
	sm_logo varchar(150) not null default '' comment '小图',-- 可以为空
	mid_logo varchar(150) not null default '' comment '中图',-- 可以为空
	big_logo varchar(150) not null default '' comment '大图',-- 可以为空
	mbig_logo varchar(150) not null default '' comment '更大图',-- 可以为空
	primary key (id),
        key shop_price(shop_price),
	key brand_id(brand_id),
	key addtime(addtime),
	key is_on_sale(is_on_sale)
)engine=InnoDB default charset=utf8 comment '商品表';

drop table if exists p39_brand;
create table p39_brand
(
	id mediumint unsigned not null auto_increment comment 'Id',
	brand_name varchar(30) not null comment '品牌名称',
	site_url varchar(150) not null default '' comment '官方网址',-- 官方网址可以为空
	logo varchar(150) not null default '' comment '品牌Logo图片',-- 品牌logo可以为空
	primary key (id)
)engine=InnoDB default charset=utf8 comment '品牌表';

drop table if exists p39_member_level;
create table p39_member_level
(
	id mediumint unsigned not null auto_increment comment 'Id',
	level_name varchar(30) not null comment '级别名称',
	jifen_bottom mediumint unsigned not null comment '积分下限',
	jifen_top mediumint unsigned not null comment '积分上线',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '会员等级表';

drop table if exists p39_member_price;
create table p39_member_price
(
	id mediumint unsigned not null auto_increment comment 'Id',
	level_id mediumint unsigned not null  comment '会员Id',
	good_id mediumint unsigned not null comment '商品id',
	price decimal(10,2) not null  comment '积分上线',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '会员价格表';

drop table if exists p39_good_phone;
create table p39_good_phone
(
	id mediumint unsigned not null auto_increment comment 'Id',
	good_id mediumint unsigned not null comment '商品id',
        pic varchar(150) not null default '' comment '原图',
	sm_pic varchar(150) not null default '' comment '小图',
	mid_pic varchar(150) not null default '' comment '中图',
	big_pic varchar(150) not null default '' comment '大图',
	primary key (id),
         key good_id(good_id),
)engine=InnoDB default charset=utf8 comment '商品相册表';


