<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Salary Slip - {{ $salary->employee->full_name }}</title>
    <style>
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; color: #1a1a2e; margin: 20px; }
        .slip-container { max-width: 800px; margin: 0 auto; }
        .slip-header { text-align: center; border-bottom: 2px solid #6c5ce7; padding-bottom: 16px; margin-bottom: 20px; }
        .company-name { font-size: 20px; font-weight: 700; color: #1a1a2e; margin: 0; }
        .company-sub { font-size: 11px; color: #6b6b80; }
        .slip-title { font-size: 16px; font-weight: 600; color: #6c5ce7; margin: 6px 0 0 0; }
        .slip-info { display: table; width: 100%; margin-bottom: 16px; padding: 12px; background: #f8f9fa; border: 1px solid #e8eaed; }
        .slip-info .row { display: table-row; }
        .slip-info .item { display: table-cell; padding: 4px 8px; width: 50%; }
        .label { font-size: 10px; color: #6b6b80; display: block; }
        .value { font-size: 13px; font-weight: 600; color: #1a1a2e; }
        .slip-table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        .slip-table th { padding: 8px 10px; text-align: left; font-size: 11px; font-weight: 600; background: #f8f9fa; border: 1px solid #e8eaed; }
        .slip-table td { padding: 8px 10px; font-size: 12px; border: 1px solid #e8eaed; }
        .label-cell { background: #fafafc; font-weight: 500; }
        .amount-cell { text-align: right; }
        .total-row td { font-weight: 700; background: #f0f0f5; }
        .slip-total { margin-top: 16px; padding: 12px; background: #f8f9fa; border: 1px solid #e8eaed; text-align: right; }
        .gross { font-size: 14px; }
        .net { font-size: 18px; font-weight: 700; color: #6c5ce7; }
        .slip-footer { margin-top: 20px; text-align: center; font-size: 10px; color: #6b6b80; border-top: 1px solid #e8eaed; padding-top: 16px; }
        .status-badge { display: inline-block; padding: 2px 10px; font-size: 10px; color: #fff; }
        .status-paid { background: #8b5cf6; }
        .status-approved { background: #10b981; }
        .status-generated { background: #3b82f6; }
    </style>
</head>
<body>
    <div class="slip-container">
        <!-- Header -->
        <div class="slip-header">
            <h1 class="company-name">Natural Vertex Ltd.</h1>
            <p class="company-sub">116/A DIT Road, Malibag Rail gate, Dhaka-1217, Bangladesh</p>
            <p class="company-sub">Phone: +8801745033031 | Email: info@naturalvertex.com</p>
            <h3 class="slip-title">SALARY SLIP</h3>
        </div>

        <!-- Employee Info -->
        <div class="slip-info">
            <div class="row">
                <div class="item">
                    <span class="label">Employee Name</span>
                    <span class="value">{{ $salary->employee->full_name ?? 'N/A' }}</span>
                </div>
                <div class="item">
                    <span class="label">Employee ID</span>
                    <span class="value">{{ $salary->employee->employee_id ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="row">
                <div class="item">
                    <span class="label">Department</span>
                    <span class="value">{{ $salary->employee->department->name ?? 'N/A' }}</span>
                </div>
                <div class="item">
                    <span class="label">Designation</span>
                    <span class="value">{{ $salary->employee->designation->name ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="row">
                <div class="item">
                    <span class="label">Salary Month</span>
                    <span class="value">{{ $salary->month_year }}</span>
                </div>
                <div class="item">
                    <span class="label">Status</span>
                    <span class="value">
                        <span class="status-badge status-{{ $salary->status }}">
                            {{ $salary->status_label }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Salary Details -->
        <table class="slip-table">
            <thead>
                <tr>
                    <th colspan="2">Earnings</th>
                    <th colspan="2">Deductions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-cell">Basic Salary</td>
                    <td class="amount-cell">৳ {{ number_format($salary->basic_salary, 2) }}</td>
                    <td class="label-cell">Tax Deduction</td>
                    <td class="amount-cell">৳ {{ number_format($salary->tax_deduction, 2) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">House Rent</td>
                    <td class="amount-cell">৳ {{ number_format($salary->house_rent, 2) }}</td>
                    <td class="label-cell">Loan Deduction</td>
                    <td class="amount-cell">৳ {{ number_format($salary->loan_deduction, 2) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Medical Allowance</td>
                    <td class="amount-cell">৳ {{ number_format($salary->medical_allowance, 2) }}</td>
                    <td class="label-cell">Advance Deduction</td>
                    <td class="amount-cell">৳ {{ number_format($salary->advance_deduction, 2) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Conveyance</td>
                    <td class="amount-cell">৳ {{ number_format($salary->conveyance, 2) }}</td>
                    <td class="label-cell">Other Deduction</td>
                    <td class="amount-cell">৳ {{ number_format($salary->other_deduction, 2) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Other Allowance</td>
                    <td class="amount-cell">৳ {{ number_format($salary->other_allowance, 2) }}</td>
                    <td rowspan="2" style="vertical-align:middle; text-align:center; font-weight:600; background:#fafafc;">
                        Total Deduction
                    </td>
                    <td rowspan="2" style="text-align:right; font-weight:600; background:#fafafc;">
                        ৳ {{ number_format($salary->tax_deduction + $salary->loan_deduction + $salary->advance_deduction + $salary->other_deduction, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Bonus</td>
                    <td class="amount-cell">৳ {{ number_format($salary->bonus, 2) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Overtime Amount</td>
                    <td class="amount-cell">৳ {{ number_format($salary->overtime_amount, 2) }}</td>
                    <td colspan="2"></td>
                </tr>
                <tr class="total-row">
                    <td colspan="2" style="text-align:right; font-size:13px;">
                        Gross Salary
                    </td>
                    <td colspan="2" style="text-align:right; font-size:13px;">
                        ৳ {{ number_format($salary->gross_salary, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <div class="slip-total">
            <div class="gross">
                Gross Salary: ৳ {{ number_format($salary->gross_salary, 2) }}
            </div>
            <div class="net">
                Net Payable: ৳ {{ number_format($salary->net_salary, 2) }}
            </div>
            <div style="font-size:11px; color:#6b6b80; margin-top:4px;">
                Present: {{ $salary->total_present }} days | 
                Absent: {{ $salary->total_absent }} days | 
                Late: {{ $salary->total_late }} days | 
                OT: {{ number_format($salary->total_overtime_hours, 1) }}h
            </div>
        </div>

        <!-- Footer -->
        <div class="slip-footer">
            <p>This is a computer-generated salary slip. No signature is required.</p>
            <p>Generated on: {{ $salary->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </div>
</body>
</html>