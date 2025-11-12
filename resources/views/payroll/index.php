<?php
use App\Models\Employee;
use App\Services\DTO\PayrollResult;
use App\Support\PersianFormatter;
/** @var Employee $employee */
/** @var PayrollResult $result */
?>
<?php ob_start(); ?>
<section class="employee-card">
    <h2>اطلاعات پرسنل</h2>
    <dl>
        <div>
            <dt>کد پرسنلی</dt>
            <dd><?= PersianFormatter::toPersianDigits($employee->code) ?></dd>
        </div>
        <div>
            <dt>نام و نام خانوادگی</dt>
            <dd><?= htmlspecialchars($employee->fullName()) ?></dd>
        </div>
        <div>
            <dt>سمت</dt>
            <dd><?= htmlspecialchars($employee->position) ?></dd>
        </div>
        <div>
            <dt>واحد سازمانی</dt>
            <dd><?= htmlspecialchars($employee->department) ?></dd>
        </div>
        <div>
            <dt>کد ملی</dt>
            <dd><?= PersianFormatter::toPersianDigits($employee->nationalId) ?></dd>
        </div>
        <div>
            <dt>تاریخ استخدام</dt>
            <dd><?= $employee->employmentDateJalali() ?></dd>
        </div>
        <div>
            <dt>حقوق پایه</dt>
            <dd><?= PersianFormatter::formatCurrency($employee->baseSalary) ?></dd>
        </div>
        <div>
            <dt>روزهای کارکرد</dt>
            <dd><?= PersianFormatter::toPersianDigits((string) $employee->workDays) ?></dd>
        </div>
    </dl>
</section>
<section class="payroll-summary" style="margin-top:2.5rem;">
    <div class="summary-card">
        <h3>مزايا</h3>
        <div class="amount"><?= PersianFormatter::formatCurrency($result->totalAllowances()) ?></div>
        <ul>
            <?php foreach ($result->allowances as $allowance): ?>
                <li><?= htmlspecialchars($allowance->name) ?> — <?= PersianFormatter::formatCurrency($allowance->amount) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="summary-card">
        <h3>کسورات</h3>
        <div class="amount"><?= PersianFormatter::formatCurrency($result->totalDeductions()) ?></div>
        <ul>
            <?php foreach ($result->deductions as $deduction): ?>
                <li><?= htmlspecialchars($deduction->name) ?> — <?= PersianFormatter::formatCurrency($deduction->amount) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="summary-card">
        <h3>خالص پرداختی</h3>
        <div class="amount"><?= PersianFormatter::formatCurrency($result->netIncome()) ?></div>
        <ul>
            <li>جمع حقوق و مزایا: <?= PersianFormatter::formatCurrency($result->grossIncome()) ?></li>
            <li>کسورات: <?= PersianFormatter::formatCurrency($result->totalDeductions()) ?></li>
            <li>خالص پرداختی: <?= PersianFormatter::formatCurrency($result->netIncome()) ?></li>
        </ul>
    </div>
</section>
<?php $slot = ob_get_clean();
$title = 'نمونه فیش حقوقی پرسنل';
include __DIR__ . '/../layouts/app.php';
