# coupon-plugin

> 开发中...

## 当前版本

[![Latest Stable Version](https://img.shields.io/packagist/v/windomz/coupon-plugin.svg?style=flat-square)](https://packagist.org/packages/windomz/coupon-plugin)

## 运行环境

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Minimum MYSQL Version](https://img.shields.io/badge/mysql-%3E%3D%205.6-4479a1.svg?style=flat-square)](https://www.mysql.com/)

## 安装与更新

```bash
$ composer require windomz/coupon-plugin
```

## 使用用法

### 配置文件

创建并编写`config.yml`，里面参数根据您的环境情况修改：
```yaml
database:
    host: 127.0.0.1
    port: 3306
    type: mysql
    name: testdb
    username: root
    password: root
```

如果只是作为测试，可以在`MySQL`运行`./sql/testdb.sql`来快速创建测试数据库。

在项目初始化阶段，**加载**指定配置文件：
```php
Coupon::setConfigPath('./config.yml');
```

### 业务流程

- 创建优惠卷：优惠卷活动(`Activity`) -> 优惠卷模板(`CouponTemplate`) -> 优惠卷(`Coupon`)

### 属性字段

#### 优惠卷活动(`Activity`)

|类型|字段|允许修改|描述|
|---|---|:---:|---|
|string|id|N|UUID|
|string|post_time|N|创建时间|
|string|put_time|N|修改时间|
|string|name|Y|名称|
|string|note|Y|描述|
|string|url|Y|链接地址|
|int|class|N|类别(第一级分类，单选，可选)，采用分类方式：0, 1, 2, 3, 4, 5, 6, 7...|
|int|kind|N|类型(第二级分类，多选，可选)，采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|int|coupon_size|Y|优惠卷派放总额|
|int|coupon_used|N|优惠卷派放数量|
|int|coupon_limit|Y|优惠卷派放次数限制|
|int|level|Y|活动等级|
|bool|valid|Y|是否有效|
|string|dead_time|Y|截止时间|

#### 优惠卷模板(`CouponTemplate`)

|类型|字段|允许修改|描述|
|---|---|:---:|---|
|string|id|N|UUID|
|string|post_time|N|创建时间|
|string|put_time|N|修改时间|
|int|class|N|类别(第一级分类，单选，可选)，采用分类方式：0, 1, 2, 3, 4, 5, 6, 7...|
|int|kind|N|类型(第二级分类，多选，可选)，采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|string|product_id|N|关联商品UUID(第二级分类，单选，可选)|
|string|name|Y|名称|
|string|desc|Y|描述|
|float|min_amount|N|满减条件金额|
|float|offer_amount|N|满减金额|
|bool|valid|Y|是否有效|
|string|dead_time|Y|截止时间|

#### 优惠卷(`Coupon`)

|类型|字段|允许修改|描述|
|---|---|:---:|---|
|string|id|N|UUID|
|string|post_time|N|创建时间|
|string|put_time|N|修改时间|
|string|owner_id|N|用户UUID|
|string|activity_id|N|活动UUID|
|string|template_id|N|优惠卷模板UUID|
|int|used_count|N|优惠卷使用次数|
|string|used_time|N|优惠卷使用时间|
|int|class|N|类别(第一级分类，单选，可选)，同`CouponTemplate`|
|int|kind|N|类型(第二级分类，多选，可选)，同`CouponTemplate`|
|string|product_id|N|关联商品UUID(第二级分类，单选，可选)，同`CouponTemplate`|
|string|name|Y|名称|
|string|desc|Y|描述|
|float|min_amount|N|满减条件金额|
|float|offer_amount|N|满减金额|
|bool|valid|Y|是否有效|
|string|dead_time|Y|截止时间|

### 接口方法

#### 优惠卷活动(`Activity`)

- MActivity::object($name, $note, $coupon_size, $coupon_limit, $second)
  - @description 构建优惠卷活动(`Activity`)
  - @param
    - string $name 名称
    - string $note 描述
    - int $coupon_size 优惠卷派放总额
    - int $coupon_limit 优惠卷派放次数限制
    - int $second 有效期（从现在起，秒）
  - @return object

- MActivity::post($obj)
  - @description 快速创建优惠卷活动(`Activity`)
  - @param
    - object $obj 由`MActivity::object`构建返回的对象
  - @return bool

- MActivity::put($id, $callback, $columns)
  - @description 修改指定优惠卷活动(`Activity`)
  - @param
    - string $id 优惠卷活动UUID
    - function $callback 回调处理`Activity`的方法
    - array $columns 修改字段，选用`MActivity::COL_`开头的字段
  - @return object

- MActivity::get($id)
  - @description 获取一个优惠卷活动(`Activity`)
  - @param
    - string $id 优惠卷活动UUID
  - @return object

- MActivity::list($where, $limit, $page)
  - @description 获取一组优惠卷活动(`Activity`)
  - @param
    - array $where 筛选范围，选用`MActivity::COL_`开头的字段
    - int $limit 筛选数量
    - int $page 筛选页数
  - @return array

- MActivity::disable($obj)
  - @description 取消优惠卷活动(`Activity`)
  - @param
    - object|string $obj 由`MActivity::object`构建返回的对象|优惠卷活动UUID
  - @return bool

#### 优惠卷模板(`CouponTemplate`)

- MCouponTemplate::object($name, $desc, $min_amount, $offer_amount, $second)
  - @description 构建优惠卷模板(`CouponTemplate`)
  - @param
    - string $name 名称
    - string $desc 描述
    - float $min_amount 满减条件金额
    - float $offer_amount 满减金额
    - int $second 有效期（从现在起，秒）
  - @return object

- MCouponTemplate::post($obj)
  - @description 快速创建优惠卷模板(`CouponTemplate`)
  - @param
    - object $obj 由`MCouponTemplate::object`构建返回的对象
  - @return bool

- MCouponTemplate::put($id, $callback, $columns)
  - @description 修改指定优惠卷模板(`CouponTemplate`)
  - @param
    - string $id 优惠卷模板UUID
    - function $callback 回调处理`CouponTemplate`的方法
    - array $columns 修改字段，选用`MCouponTemplate::COL_`开头的字段
  - @return object

- MCouponTemplate::get($id)
  - @description 获取一个优惠卷模板(`CouponTemplate`)
  - @param
    - string $id 优惠卷模板UUID
  - @return object

- MCouponTemplate::list($where, $limit, $page)
  - @description 获取一组优惠卷模板(`CouponTemplate`)
  - @param
    - array $where 筛选范围，选用`MCouponTemplate::COL_`开头的字段
    - int $limit 筛选数量
    - int $page 筛选页数
  - @return array

- MCouponTemplate::disable($obj)
  - @description 取消优惠卷模板(`CouponTemplate`)
  - @param
    - object|string $obj 由`MCouponTemplate::object`构建返回的对象|优惠卷模板UUID
  - @return bool

#### 优惠卷(`Coupon`)

- MCoupon::object($owner_id, $activity_id, $template_id, $second)
  - @description 构建优惠卷(`Coupon`)
  - @param
    - string $owner_id 用户UUID
    - string $activity_id 活动UUID
    - string $template_id 优惠卷模板UUID
    - int $second 有效期（从现在起，秒）
  - @return object

- MCoupon::post($obj)
  - @description 快速创建优惠卷(`Coupon`)
  - @param
    - object $obj 由`MCoupon::object`构建返回的对象
  - @return bool

- MCoupon::put($id, $callback, $columns)
  - @description 修改指定优惠卷(`Coupon`)
  - @param
    - string $id 优惠卷UUID
    - function $callback 回调处理`Coupon`的方法
    - array $columns 修改字段，选用`MCoupon::COL_`开头的字段
  - @return bool

- MCoupon::get($id)
  - @description 获取一个优惠卷(`Coupon`)
  - @param
    - string $id 优惠卷UUID
  - @return object

- MCoupon::list($where, $limit, $page)
  - @description 获取一组优惠卷(`Coupon`)
  - @param
    - array $where 筛选范围，选用`MCoupon::COL_`开头的字段
    - int $limit 筛选数量
    - int $page 筛选页数
  - @return array

- MCoupon::disable($obj)
  - @description 快速创建优惠卷(`Coupon`)
  - @param
    - object|string $obj 由`MCoupon::object`构建返回的对象|优惠卷UUID
  - @return bool

- MCoupon::use($obj)
  - @description 使用优惠卷(`Coupon`)
  - @param
    - object|string $obj 由`MCoupon::object`构建返回的对象|优惠卷UUID
  - @return bool

#### 公共方法

- M*::toJSON($obj)
  - @description 转为JSON格式对象
  - @demo `MCoupon::toJSON(MCoupon::get('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'))`
  - @param
    - object $obj 对象
  - @return object

- M*::where($type, $key)
  - @description 使用`M*::list($where, $limit, $page)`时，构造`$where`的高级用法。
  - @demo `[MCoupon::where(MCoupon::WHERE_GTE, MCoupon::COL_CLASS) => 10]`，等同于`[MCoupon::COL_CLASS>=10]`。
  - @param
    - int $type 对象
    - string $key 对象
  - @return object
