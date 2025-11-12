<?php
use App\Modules\Module;
/** @var Module[] $modules */
?>
<?php ob_start(); ?>
<section class="table-wrapper">
    <div class="table-title">
        <h2>لیست کامل ماژول‌ها</h2>
        <a href="/">بازگشت به داشبورد</a>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 220px;">ماژول</th>
                <th>شرح امکانات کلیدی</th>
                <th style="width: 120px;">دسته‌بندی</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modules as $module): ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($module->name) ?></strong>
                    </td>
                    <td>
                        <ul style="margin: 0; padding-right: 1.1rem;">
                            <?php foreach ($module->features as $feature): ?>
                                <li><?= htmlspecialchars($feature) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if ($module->description): ?>
                            <p style="margin-top: .75rem; color: #6366f1; font-size: .85rem;">
                                <?= htmlspecialchars($module->description) ?>
                            </p>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge <?= $module->category === 'ویژه' ? 'warning' : 'success' ?>">
                            <?= htmlspecialchars($module->category) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php $slot = ob_get_clean();
$title = 'ماژول‌های سامانه حقوق و دستمزد';
include __DIR__ . '/../layouts/app.php';
