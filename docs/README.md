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

创建并编写`config.yml`
```yaml
database:
    host: 127.0.0.1
    port: 3306
    type: mysql
    name: testdb
    username: root
    password: root
```

在项目初始化阶段，加载指定配置文件
```php
Coupon::$configPath = './config.yml';
```

### 属性字段

#### 优惠卷模板(`CouponTemplate`)

|类型|字段|修改|描述|
|---|---|:---:|---|
|string|id|N|UUID|
|string|post_time|N|创建时间|
|string|put_time|N|修改时间|
|int|class|Y|类别(第一级分类)，推荐采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|int|kind|Y|类型(第二级分类)，推荐采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|string|name|Y|名称|
|string|desc|Y|描述|
|int|min_amount|Y|满减条件金额|
|int|offer_amount|Y|满减金额|
|int|coupon_limit|Y|优惠卷次数限制|
|bool|valid|Y|是否有效|
|string|dead_time|Y|截止时间|

#### 优惠卷(`Coupon`)

|类型|字段|修改|描述|
|---|---|:---:|---|
|string|id|N|UUID|
|string|post_time|N|创建时间|
|string|put_time|N|修改时间|
|string|owner_id|N|用户UUID|
|string|activity_id|N|活动UUID|
|string|template_id|N|优惠卷模板UUID|
|int|used_count|N|优惠卷使用次数|
|string|used_time|N|优惠卷使用时间|
|int|class|Y|类别(第一级分类)，推荐采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|int|kind|Y|类型(第二级分类)，推荐采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|string|name|Y|名称|
|string|desc|Y|描述|
|int|min_amount|Y|满减条件金额|
|int|offer_amount|Y|满减金额|
|int|coupon_limit|Y|优惠卷次数限制|
|bool|valid|Y|是否有效|
|string|dead_time|Y|截止时间|

### 接口方法

#### 优惠卷模板(`CouponTemplate`)

- MCouponTemplate::object($name, $desc, $min_amount, $offer_amount, $second)
  - @description 构建优惠卷模板(`CouponTemplate`)
  - @param
    - string $name 名称
    - string $desc 描述
    - int $min_amount 满减条件金额
    - int $offer_amount 满减金额
    - int $second 有效期（从现在起，秒）
  - @return object

- MCouponTemplate::post($name, $desc, $min_amount, $offer_amount, $second)
  - @description 快速创建优惠卷模板(`CouponTemplate`)
  - @param
    - string $name 名称
    - string $desc 描述
    - int $min_amount 满减条件金额
    - int $offer_amount 满减金额
    - int $second 有效期（从现在起，秒）
  - @return bool

- MCouponTemplate::put($id, $callback, $columns)
  - @description 修改指定优惠卷模板(`CouponTemplate`)
  - @param
    - string $id 优惠卷模板UUID
    - function $callback 回调处理`CouponTemplate`的方法
    - array $columns 修改字段，见`MCouponTemplate::COL_`开头
  - @return object

- MCouponTemplate::get($id)
  - @description 获取一个优惠卷模板(`CouponTemplate`)
  - @param
    - string $id 优惠卷模板UUID
  - @return object

- MCouponTemplate::list($where, $limit, $page)
  - @description 获取一组优惠卷模板(`CouponTemplate`)
  - @param
    - array $where 筛选范围，见`MCouponTemplate::COL_`开头
    - int $limit 筛选数量
    - int $page 筛选页数
  - @return array

#### 优惠卷(`Coupon`)

- MCoupon::object($owner_id, $activity_id, $template_id, $second)
  - @description 构建优惠卷(`Coupon`)
  - @param
    - string $owner_id 用户UUID
    - string $activity_id 活动UUID(**未完成**)
    - string $template_id 优惠卷模板UUID
    - int $second 有效期（从现在起，秒）
  - @return object

- MCoupon::post($owner_id, $activity_id, $template_id, $second)
  - @description 快速创建优惠卷(`Coupon`)
  - @param
    - string $owner_id 用户UUID
    - string $activity_id 活动UUID(**未完成**)
    - string $template_id 优惠卷模板UUID
    - int $second 有效期（从现在起，秒）
  - @return bool

- MCoupon::put($id, $callback, $columns)
  - @description 修改指定优惠卷(`Coupon`)
  - @param
    - string $id 优惠卷UUID
    - function $callback 回调处理`Coupon`的方法
    - array $columns 修改字段，见`MCoupon::COL_`开头
  - @return bool

- MCoupon::get($id)
  - @description 获取一个优惠卷(`Coupon`)
  - @param
    - string $id 优惠卷UUID
  - @return object

- MCoupon::list($where, $limit, $page)
  - @description 获取一组优惠卷(`Coupon`)
  - @param
    - array $where 筛选范围，见`MCoupon::COL_`开头
    - int $limit 筛选数量
    - int $page 筛选页数
  - @return array
