<?php
use App\Modules\Module;
use App\Support\PersianFormatter;
/** @var Module[] $modules */
?>
<?php ob_start(); ?>
<section class="table-wrapper">
    <div class="table-title">
        <h2>ماژول‌های ویژه سیستم حقوق و دستمزد</h2>
        <a href="/modules">مشاهده همه ماژول‌ها</a>
    </div>
    <div class="card-grid">
        <?php foreach ($modules as $module): ?>
            <article class="card">
                <span class="chip">ویژه</span>
                <h2><?= htmlspecialchars($module->name) ?></h2>
                <?php if ($module->description): ?>
                    <p><?= htmlspecialchars($module->description) ?></p>
                <?php endif; ?>
                <ul>
                    <?php foreach ($module->features as $feature): ?>
                        <li><?= htmlspecialchars($feature) ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<section class="payroll-summary" style="margin-top:2.5rem;">
    <div class="summary-card">
        <h3>چرخه کامل حقوق و دستمزد</h3>
        <ul>
            <li>تعریف پارامترهای حقوقی، آیتم‌ها و فرمول‌های پویا</li>
            <li>محاسبه خودکار کارکرد، اضافه‌کار، بیمه و مالیات</li>
            <li>تولید خروجی‌های اکسل، PDF، فایل بانک و لیست بیمه</li>
        </ul>
    </div>
    <div class="summary-card">
        <h3>یکپارچه با حضور و غیاب</h3>
        <ul>
            <li>دریافت اطلاعات تردد از دستگاه‌ها و اپلیکیشن موبایل</li>
            <li>گردش کار تایید مرخصی، مأموریت و اصلاحات تردد</li>
            <li>گزارش‌های لحظه‌ای از وضعیت حضور نیروها</li>
        </ul>
    </div>
    <div class="summary-card">
        <h3>پرتال کارکنان</h3>
        <ul>
            <li>دسترسی پرسنل به فیش حقوقی، حکم و مانده مرخصی</li>
            <li>امکان ثبت درخواست‌ها و پیگیری وضعیت بصورت آنلاین</li>
            <li>ارسال اعلان‌ها و پیام‌های سیستمی</li>
        </ul>
    </div>
</section>
<?php $slot = ob_get_clean();
$title = 'داشبورد سیستم حقوق و دستمزد';
include __DIR__ . '/layouts/app.php';
