<?php
declare(strict_types=1);

use App\Support\PersianFormatter;

$earnings = array_values(array_filter($components, fn($component) => $component->type === 'earning'));
$deductions = array_values(array_filter($components, fn($component) => $component->type === 'deduction'));
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فیش حقوقی</title>
    <style>
        body {
            font-family: "Vazirmatn", "IRANSans", sans-serif;
            background-color: #f5f5f5;
            color: #1f2937;
            margin: 0;
            padding: 2rem;
        }
        .payslip {
            max-width: 960px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
            padding: 2.5rem;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1.5rem;
        }
        header h1 {
            margin: 0;
            font-size: 1.75rem;
            color: #111827;
        }
        .meta {
            font-size: 0.95rem;
            line-height: 1.8;
        }
        .meta strong {
            display: inline-block;
            min-width: 120px;
            color: #2563eb;
        }
        .sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f9fafb;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background-color: #2563eb;
            color: #fff;
            padding: 0.85rem 1rem;
            text-align: right;
            font-weight: 600;
        }
        td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .amount {
            font-weight: 600;
            color: #0f172a;
        }
        .description {
            font-size: 0.85rem;
            color: #6b7280;
        }
        footer {
            margin-top: 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2563eb;
            color: #fff;
            padding: 1.25rem 1.75rem;
            border-radius: 10px;
        }
        footer .label {
            font-size: 0.95rem;
            opacity: 0.85;
        }
        footer .value {
            font-size: 1.3rem;
            font-weight: 700;
        }
    </style>
</head>
<body>
<div class="payslip">
    <header>
        <div>
            <h1>فیش حقوقی ماهانه</h1>
            <div class="meta">
                <div><strong>نام و نام خانوادگی:</strong> <?= PersianFormatter::toPersianDigits($employeeData['full_name']); ?></div>
                <div><strong>کد ملی:</strong> <?= PersianFormatter::toPersianDigits($employeeData['national_code']); ?></div>
                <div><strong>تعداد فرزندان:</strong> <?= PersianFormatter::toPersianDigits((string) $employeeData['children_count']); ?></div>
            </div>
        </div>
        <div class="meta">
            <div><strong>تاریخ صدور:</strong> <?= $persianDate; ?></div>
            <div><strong>روزهای کارکرد:</strong> <?= PersianFormatter::toPersianDigits((string) $employeeData['work_days']); ?></div>
            <div><strong>ساعات اضافه کاری:</strong> <?= PersianFormatter::toPersianDigits((string) $employeeData['overtime_hours']); ?></div>
        </div>
    </header>

    <div class="sections">
        <section>
            <table>
                <thead>
                <tr>
                    <th>شرح مزایا</th>
                    <th>مبلغ (ریال)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($earnings as $item): ?>
                    <tr>
                        <td>
                            <div><?= htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php if ($item->description): ?>
                                <div class="description"><?= htmlspecialchars($item->description, ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="amount"><?= PersianFormatter::formatCurrency($item->amount); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section>
            <table>
                <thead>
                <tr>
                    <th>شرح کسورات</th>
                    <th>مبلغ (ریال)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($deductions as $item): ?>
                    <tr>
                        <td>
                            <div><?= htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php if ($item->description): ?>
                                <div class="description"><?= htmlspecialchars($item->description, ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="amount"><?= PersianFormatter::formatCurrency($item->amount); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>

    <footer>
        <div>
            <div class="label">جمع مزایا</div>
            <div class="value"><?= PersianFormatter::formatCurrency($result->earningTotal()); ?></div>
        </div>
        <div>
            <div class="label">جمع کسورات</div>
            <div class="value"><?= PersianFormatter::formatCurrency($result->deductionTotal()); ?></div>
        </div>
        <div>
            <div class="label">حقوق قابل پرداخت</div>
            <div class="value"><?= PersianFormatter::formatCurrency($result->netPay()); ?></div>
        </div>
    </footer>
</div>
</body>
</html>
