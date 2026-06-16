<?php
/**
 * 时间胶囊 - 配置文件
 * 部署时请务必修改以下配置
 */

return [

    // ========== 数据库 ==========
    'db_path' => __DIR__ . '/data/capsules.db',

    // ========== 站点地址（用于邮件中的链接） ==========
    'site_url' => 'https://your-domain.com/time-capsule',

    // ========== 邮件发送 ==========
    'mail' => [
        // 驱动：'smtp'（推荐） 或 'mail'（PHP内置，不靠谱）
        'driver' => 'smtp',

        // SMTP 配置（以QQ邮箱为例）
        'smtp_host' => 'smtp.qq.com',
        'smtp_port' => 465,
        'smtp_secure' => 'ssl',     // 'ssl' 或 'tls'
        'smtp_user' => 'your-email@qq.com',
        'smtp_pass' => 'your-smtp-authorization-code',  // 注意是授权码不是登录密码

        // 发件人信息
        'from_name'  => '时光胶囊',
        'from_email' => 'your-email@qq.com',
    ],

    // ========== Cron 密钥 ==========
    // 防止 send.php 被随意访问，调用时需带上 ?key=xxx
    'cron_key' => 'please-change-this-to-a-random-string',

    // ========== 频率限制 ==========
    // 同一IP每天最多创建多少个胶囊
    'rate_limit' => 5,
];
