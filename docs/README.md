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

### 模块定义

- 优惠卷活动(`Activity`): 方便管理优惠卷的发放
- 优惠卷模板(`CouponTemplate`): 方便管理优惠卷的样式
- 优惠卷包(`Pack`): 方便统一生成优惠卷
- 优惠卷(`Coupon`): 指定用户的优惠卷

### 业务流程

- 创建优惠卷：优惠卷活动(`Activity`) -> 优惠卷模板(`CouponTemplate`) -> 优惠卷包(`Pack`) -> 优惠卷(`Coupon`)

### 属性字段

#### 优惠卷活动(`Activity`)

|类型|字段|必填|修改|描述|
|---|---|:---:|---|
|string|id|N|N|UUID|
|string|post_time|N|N|创建时间|
|string|put_time|N|N|修改时间|
|string|name|Y|Y|名称|
|string|note|N|Y|描述|
|string|url|N|Y|链接地址|
|int|class|Y|N|类别(第一级分类，单选，可选)，采用分类方式：0, 1, 2, 3, 4, 5, 6, 7...|
|int|kind|Y|N|类型(第二级分类，多选，可选)，采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|int|coupon_size|Y|Y|优惠卷派放总额|
|int|coupon_used|N|N|优惠卷派放数量|
|int|coupon_limit|Y|Y|优惠卷派放次数限制|
|int|level|N|Y|活动等级|
|bool|valid|Y|Y|是否有效|
|string|dead_time|Y|Y|截止时间|

#### 优惠卷模板(`CouponTemplate`)

|类型|字段|必填|修改|描述|
|---|---|:---:|---|
|string|id|N|N|UUID|
|string|post_time|N|N|创建时间|
|string|put_time|N|N|修改时间|
|int|class|Y|N|类别(第一级分类，单选，可选)，采用分类方式：0, 1, 2, 3, 4, 5, 6, 7...|
|int|kind|Y|N|类型(第二级分类，多选，可选)，采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|string|product_id|N|N|关联商品UUID(第二级分类，单选，可选)|
|string|name|Y|Y|名称|
|string|desc|N|Y|描述|
|float|min_amount|Y|N|满减条件金额|
|float|offer_amount|Y|N|满减金额|
|bool|valid|Y|Y|是否有效|

#### 优惠卷包(`Pack`)

|类型|字段|必填|修改|描述|
|---|---|:---:|---|
|string|id|N|N|UUID|
|string|post_time|N|N|创建时间|
|string|put_time|N|N|修改时间|
|string|name|Y|Y|名称|
|string|activity_id|Y|N|活动UUID|
|string|template_id|Y|N|优惠卷模板UUID|
|int|level|N|Y|活动等级|
|bool|valid|Y|Y|是否有效|
|string|dead_time|Y|Y|截止时间|

#### 优惠卷(`Coupon`)

|类型|字段|必填|修改|描述|
|---|---|:---:|---|
|string|id|N|N|UUID|
|string|post_time|N|N|创建时间|
|string|put_time|N|N|修改时间|
|string|owner_id|Y|N|用户UUID|
|string|activity_id|Y|N|活动UUID|
|string|template_id|Y|N|优惠卷模板UUID|
|int|used_count|N|N|优惠卷使用次数|
|string|used_time|N|N|优惠卷使用时间|
|int|class|Y|N|类别(第一级分类，单选，可选)，同`CouponTemplate`|
|int|kind|Y|N|类型(第二级分类，多选，可选)，同`CouponTemplate`|
|string|product_id|N|N|关联商品UUID(第二级分类，单选，可选)，同`CouponTemplate`|
|string|name|Y|Y|名称|
|string|desc|N|Y|描述|
|float|min_amount|Y|N|满减条件金额|
|float|offer_amount|Y|N|满减金额|
|bool|valid|Y|Y|是否有效|
|string|dead_time|Y|Y|截止时间|

### 接口方法

#### 优惠卷活动(`Activity`)

- MActivity::object($name, $note, $coupon_size, $coupon_limit)
  - @description 构建优惠卷活动(`Activity`)
  - @param
    - string $name 名称
    - string $note 描述
    - int $coupon_size 优惠卷派放总额
    - int $coupon_limit 优惠卷派放次数限制
  - @return object

- MActivity::post($obj)
  - @description 快速创建优惠卷活动(`Activity`)
  - @param
    - object $obj 由`MActivity::object`构建返回的对象
  - @return bool

- MActivity::put($obj, $columns)
  - @description 修改指定优惠卷活动(`Activity`)
  - @param
    - object $obj 由`MActivity::get`返回的对象
    - array $columns 标明修改的字段，选用`MActivity::COL_`开头的字段
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
    - object|string $obj 由`MActivity::get`返回的对象|优惠卷活动UUID
  - @return bool

#### 优惠卷模板(`CouponTemplate`)

- MCouponTemplate::object($name, $desc, $min_amount, $offer_amount)
  - @description 构建优惠卷模板(`CouponTemplate`)
  - @param
    - string $name 名称
    - string $desc 描述
    - float $min_amount 满减条件金额
    - float $offer_amount 满减金额
  - @return object

- MCouponTemplate::post($obj)
  - @description 快速创建优惠卷模板(`CouponTemplate`)
  - @param
    - object $obj 由`MCouponTemplate::object`构建返回的对象
  - @return bool

- MCouponTemplate::put($obj, $columns)
  - @description 修改指定优惠卷模板(`CouponTemplate`)
  - @param
    - object $obj 由`MCouponTemplate::get`返回的对象
    - array $columns 标明修改的字段，选用`MCouponTemplate::COL_`开头的字段
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
    - object|string $obj 由`MCouponTemplate::get`返回的对象|优惠卷模板UUID
  - @return bool

#### 优惠卷包(`Pack`)

- MPack::object($name, $activity_id, $template_id)
  - @description 构建优惠卷包(`Pack`)
  - @param
    - string $name 名称
    - string $activity_id 活动UUID
    - string $template_id 优惠卷模板UUID
  - @return object

- MPack::post($obj)
  - @description 快速创建优惠卷包(`Pack`)
  - @param
    - object $obj 由`MPack::object`构建返回的对象
  - @return bool

- MPack::put($obj, $columns)
  - @description 修改指定优惠卷包(`Pack`)
  - @param
    - object $obj 由`MPack::get`返回的对象
    - array $columns 标明修改的字段，选用`MPack::COL_`开头的字段
  - @return object

- MPack::get($id)
  - @description 获取一个优惠卷包(`Pack`)
  - @param
    - string $id 优惠卷活动UUID
  - @return object

- MPack::list($where, $limit, $page)
  - @description 获取一组优惠卷包(`Pack`)
  - @param
    - array $where 筛选范围，选用`MPack::COL_`开头的字段
    - int $limit 筛选数量
    - int $page 筛选页数
  - @return array

- MPack::disable($obj)
  - @description 取消优惠卷包(`Pack`)
  - @param
    - object|string $obj 由`MPack::get`返回的对象|优惠卷活动UUID
  - @return bool

#### 优惠卷(`Coupon`)

- MCoupon::object($owner_id, $pack_id)
  - @description 构建优惠卷(`Coupon`)
  - @param
    - string $owner_id 用户UUID
    - string $pack_id 优惠卷包UUID
  - @return object

- MCoupon::post($obj)
  - @description 快速创建优惠卷(`Coupon`)
  - @param
    - object $obj 由`MCoupon::object`构建返回的对象
  - @return bool

- MCoupon::put($obj, $columns)
  - @description 修改指定优惠卷(`Coupon`)
  - @param
    - object $obj 由`MCoupon::get`返回的对象
    - array $columns 标明修改的字段，选用`MCoupon::COL_`开头的字段
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
    - object|string $obj 由`MCoupon::get`返回的对象|优惠卷UUID
  - @return bool

- MCoupon::use($obj)
  - @description 使用优惠卷(`Coupon`)
  - @param
    - object|string $obj 由`MCoupon::get`返回的对象|优惠卷UUID
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
