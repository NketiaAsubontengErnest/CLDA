<?php
namespace App\Models;

use App\Core\Model;

class Payroll extends Model {
    public function __construct() {
        parent::__construct();
        \App\Core\PayrollSchema::ensure($this->db);
    }

    // Ghana defaults: SSNIT employee contribution 5.5% of basic; PAYE on monthly chargeable income.
    // Adjust these if statutory rates change.
    const SSNIT_RATE = 0.055;

    public static function paye($chargeable) {
        $bands = [[490, 0], [110, 0.05], [130, 0.10], [3166.67, 0.175], [16000, 0.25], [30520, 0.30]];
        $tax = 0;
        foreach ($bands as $band) {
            $slice = min($chargeable, $band[0]);
            if ($slice <= 0) break;
            $tax += $slice * $band[1];
            $chargeable -= $slice;
        }
        if ($chargeable > 0) $tax += $chargeable * 0.35;
        return round($tax, 2);
    }

    public static function compute($basic, $allowances, $bonus, $other) {
        $gross = $basic + $allowances + $bonus;
        $ssnit = round($basic * self::SSNIT_RATE, 2);
        $tax = self::paye($gross - $ssnit);
        $deductions = $ssnit + $tax + $other;
        return [
            'gross_pay' => round($gross, 2),
            'ssnit_employee' => $ssnit,
            'income_tax' => $tax,
            'total_deductions' => round($deductions, 2),
            'net_pay' => round($gross - $deductions, 2),
        ];
    }

    public function getByMonth($month) {
        $stmt = $this->db->prepare("SELECT p.*, (p.created_at >= NOW() - INTERVAL 24 HOUR) AS deletable, e.full_name, e.employee_code, e.position FROM payroll_records p JOIN employees e ON e.id = p.employee_id WHERE p.pay_month = :m ORDER BY e.full_name");
        $stmt->execute(['m' => $month]);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT p.*, e.full_name, e.employee_code, e.position, e.department, e.bank_name, e.bank_account, e.ssnit_number, e.tin_number FROM payroll_records p JOIN employees e ON e.id = p.employee_id WHERE p.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /** Create records for all active employees that don't have one for the month. Returns count created. */
    public function generate($month, Employee $employees) {
        $count = 0;
        $stmt = $this->db->prepare("INSERT IGNORE INTO payroll_records (employee_id, pay_month, basic_salary, allowances, bonus, gross_pay, ssnit_employee, income_tax, other_deductions, total_deductions, net_pay) VALUES (:employee_id, :pay_month, :basic_salary, :allowances, 0, :gross_pay, :ssnit_employee, :income_tax, 0, :total_deductions, :net_pay)");
        foreach ($employees->getActive() as $e) {
            $c = self::compute((float)$e['basic_salary'], (float)$e['allowances'], 0, 0);
            $stmt->execute(array_merge($c, [
                'employee_id' => $e['id'],
                'pay_month' => $month,
                'basic_salary' => $e['basic_salary'],
                'allowances' => $e['allowances'],
            ]));
            $count += $stmt->rowCount();
        }
        return $count;
    }

    public function adjust($id, $bonus, $other, $notes) {
        $r = $this->find($id);
        if (!$r) return false;
        $c = self::compute((float)$r['basic_salary'], (float)$r['allowances'], $bonus, $other);
        $stmt = $this->db->prepare("UPDATE payroll_records SET bonus = :bonus, other_deductions = :other, gross_pay = :gross_pay, ssnit_employee = :ssnit_employee, income_tax = :income_tax, total_deductions = :total_deductions, net_pay = :net_pay, notes = :notes WHERE id = :id");
        return $stmt->execute(array_merge($c, ['bonus' => $bonus, 'other' => $other, 'notes' => $notes, 'id' => $id]));
    }

    public function markPaid($id) {
        return $this->db->prepare("UPDATE payroll_records SET status = 'paid', paid_at = CURDATE() WHERE id = :id")->execute(['id' => $id]);
    }

    public function delete($id) {
        return $this->db->prepare("DELETE FROM payroll_records WHERE id = :id AND created_at >= NOW() - INTERVAL 24 HOUR")->execute(["id" => $id]);
    }
}
