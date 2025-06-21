### 更新日志
- 更新了一下点击文件
![image](https://github.com/user-attachments/assets/387bf6fe-1ac7-46b7-8ca4-d22458bf3c35)
![image](https://github.com/user-attachments/assets/a7473995-8c91-491a-8919-0dddd8e9bf13)
---

# 使用说明

### 环境要求
- **PHP 版本：** 8.0
- **数据库版本：** 5.7
# 跨域开放
add_header 'Access-Control-Allow-Origin' '*';
add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, DELETE, OPTIONS';
add_header 'Access-Control-Allow-Headers' 'DNT, Keep-Alive, Users-Agent, Cache-Control, Content-Type, Auth';
add_header 'Access-Control-Allow-Credentials' 'true';
### 安装步骤

1. **上传文件：** 
   将 `admin` 文件夹上传到你的服务器。

2. **配置数据库：**
   - 打开 `admin` 文件夹中的 `db.php` 文件。
   - 修改数据库配置：
     ```php
     $username = "aaa"; // 数据库用户名
     $password = "aaa"; // 数据库密码
     $dbname = "aaa";   // 数据库名称
     ```

3. **导入数据库：**
   - 导入 `database` 文件夹中的数据库文件到你的数据库中。

4. **访问配置页面：**
   - 在浏览器中访问：`/admin/admin.php`，进入配置页面。
   - 在此页面，你可以添加目标站点的域名。多个域名会自动轮询使用。

5. **设置 API 域名：**
   - 你需要在云文件配置中，替换成你自己的 API 域名，否则访问时页面将是空白。
   - 如果正确配置了目标域名，但仍显示空白，可能是因为没有添加目标域名。

### 云文件说明

假设你上传的云文件路径是：`https://xxx.com/user-attac.html`

- **无参数访问：** 直接访问 `https://xxx.com/user-attac.html` 会看到空白页面。
- **带参数访问：** 访问 `https://xxx.com/user-attac.html?123&cshu`，携带的参数会被拼接到目标站点的 URL 后进行跳转。

### 系统介绍

这是一个简单的支持云文件防洪跳转系统。工作原理如下：
- 如果当前 URL 含有查询参数（例如 `?123&cshu`），这些参数会被自动拼接到你配置的目标站点 URL 后，系统会进行跳转。
- `admin` 文件夹是后台管理部分，`cloud` 文件夹是入口文件，数据库用于存储相关配置。
- 纯静态版本无需后台管理，访问时随机获取一个文本文件。

### 注意事项

- 本系统仅适用于个人使用，建议不要用于大规模或商业用途。
- 数据库版本和 PHP 版本无严格要求，但推荐使用 PHP 8.0 和 MySQL 5.7。

---

这版优化后的文档更简洁，并且按照步骤清晰地说明了如何配置和使用。希望对你有帮助！
