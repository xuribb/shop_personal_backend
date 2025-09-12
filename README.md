# 商城独立站后台代码PHP

## 简介
项目采用原生开发+composer并没有采用任何PHP框架，本项目随前端项目部分停止而停止。


## 环境要求

- php >= 8.3
- mysql >= 8.0

## 部署教程

1. 安装composer依赖包

```bash
composer install --no-dev  #部署安装
composer install           #开发安装
```

2. 重命名 **.env.example** 文件为 **.env** *（注意：开发环境才需要这么做，部署服务时，请自行在服务器上配置环境变量）*

填写相关环境变量

3. 创建数据库 shop_personal，然后修改数据库文件里的域名shop.lujiawei.top为自己的域名，然后导入

4. 请将Web根目录设置为 **src/public**, 可通过修改配置文件达到

5. 伪静态如下
``` nginx
location / {  
 try_files $uri $uri/ /index.php$is_args$query_string;  
}  
```

