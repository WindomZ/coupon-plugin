# coupon-plugin

> 开发中...

## 环境

**PHP7** + **MySQL**

## 安装

```bash
$ composer require windomz/coupon-plugin
```

## 用法

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

### 使用方法

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
  - @description 创建优惠卷模板(`CouponTemplate`)
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
    - string $id uuid
    - function $callback 回调方法
    - array $columns 修改字段，见`COL_`开头常量
  - @return object

- MCouponTemplate::get($id)
  - @description 获取一个优惠卷模板(`CouponTemplate`)
  - @param
    - string $id uuid
  - @return object

- MCouponTemplate::list($where, $limit, $page)
  - @description 获取一个优惠卷模板(`CouponTemplate`)
  - @param
    - array $where 筛选范围，见`COL_`开头常量
    - int $limit 筛选数量
    - int $page 筛选页数
  - @return array
