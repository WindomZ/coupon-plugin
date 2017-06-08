# coupon-plugin

> 开发中...

## 运行环境

- \>= **PHP7**
- \>= **MySQL5.6**

## 安装与更新

```bash
$ composer require windomz/coupon-plugin
```

## 使用用法

### 配置文件

创建并编写`config.yml`，里面参数根据您的环境情况修改
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

在项目初始化阶段，加载指定配置文件
```php
Coupon::$configPath = './config.yml';
```

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
|int|class|N|类别(第一级分类)，推荐采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|int|kind|N|类型(第二级分类)，推荐采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|string|name|Y|名称|
|string|desc|Y|描述|
|float|min_amount|N|满减条件金额|
|float|offer_amount|N|满减金额|
|int|coupon_limit|N|优惠卷次数限制|
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
|int|class|N|类别(第一级分类)，推荐采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|int|kind|N|类型(第二级分类)，推荐采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|string|name|Y|名称|
|string|desc|Y|描述|
|float|min_amount|N|满减条件金额|
|float|offer_amount|N|满减金额|
|int|coupon_limit|N|优惠卷次数限制|
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

- MActivity::post($name, $note, $coupon_size, $coupon_limit, $second)
  - @description 快速创建优惠卷活动(`Activity`)
  - @param
    - string $name 名称
    - string $note 描述
    - int $coupon_size 优惠卷派放总额
    - int $coupon_limit 优惠卷派放次数限制
    - int $second 有效期（从现在起，秒）
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

- MCouponTemplate::post($name, $desc, $min_amount, $offer_amount, $second)
  - @description 快速创建优惠卷模板(`CouponTemplate`)
  - @param
    - string $name 名称
    - string $desc 描述
    - float $min_amount 满减条件金额
    - float $offer_amount 满减金额
    - int $second 有效期（从现在起，秒）
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

#### 优惠卷(`Coupon`)

- MCoupon::object($owner_id, $activity_id, $template_id, $second)
  - @description 构建优惠卷(`Coupon`)
  - @param
    - string $owner_id 用户UUID
    - string $activity_id 活动UUID
    - string $template_id 优惠卷模板UUID
    - int $second 有效期（从现在起，秒）
  - @return object

- MCoupon::post($owner_id, $activity_id, $template_id, $second)
  - @description 快速创建优惠卷(`Coupon`)
  - @param
    - string $owner_id 用户UUID
    - string $activity_id 活动UUID
    - string $template_id 优惠卷模板UUID
    - int $second 有效期（从现在起，秒）
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
