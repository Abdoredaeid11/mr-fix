<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<pre>";

$target = __DIR__ . '/storage/app/public'; // مجلد الملفات اللي هتوصلها
$link = __DIR__ . '/public/storage';        // مجلد الـ storage داخل public

echo "🎯 Target: $target\n";
echo "🔗 Link: $link\n";

// حذف أي رابط رمزي قديم
if (is_link($link)) {
    echo "⚠️ الرابط الرمزي موجود مسبقًا. يتم حذفه...\n";
    unlink($link);
}

// التأكد من وجود المجلد المصدر
if (!is_dir($target)) {
    exit("❌ مجلد الملفات مش موجود: $target");
}

// إنشاء الرابط الرمزي
if (symlink($target, $link)) {
    echo "✅ تم إنشاء الرابط الرمزي بنجاح.\n";
    echo "جرب تفتح الصورة من: https://mr-fix.org/storage/assets/category/cleaning.png";
} else {
    echo "❌ فشل إنشاء الرابط الرمزي. ممكن الاستضافة تمنع symlink.\n";
}

echo "</pre>";
