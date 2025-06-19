# 商城独立站后台代码PHP

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

3. 请将Web根目录设置为 **src/public**

