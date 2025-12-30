<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    public function authenticate($email, $password){
        $user = $this->db->query("
            SELECT *
            FROM `hr-accounts` 
            WHERE `email` = ? 
            AND `deleted_at` IS NULL" , 
            array(
                $email
            ))->getRow();

        if(!$user){
            return false;
        }
        if(password_verify($password, $user->password)){
            return $user;
        }
    }

    public function register($name, $password){
        $this->db->query("
            INSERT INTO 
            `accounts` 
            (`name`,`password`) 
            VALUES(?,?)", 
            array(
                $name, 
                $password
            ));

        $id = $this->db->insertID();
        return $this->db->query("
            SELECT `accounts`.`id`,`accounts`.`name`
            FROM `accounts` 
            WHERE `id` = ? 
            AND `deleted_at` = '0000-00-00 00:00:00
            '" , 
            array(
                $id
            ))->getRow();

    }

    public function get_offboarded_employees()
    {
        $employees = $this->db->query("
            SELECT `employees`.*,  TRIM(CONCAT_WS(' ', first_name, middle_name, last_name)) AS name, `departments`.`name` AS `department_name`
            FROM `employees` 
            LEFT JOIN `departments`
            ON `employees`.`department_id` = `departments`.`id` 
            WHERE `employees`.`onboarded` = 0 
            AND `employees`.`deleted_at` IS NULL
            AND `departments`.`deleted_at` IS NULL"
        )->getResult();

        return $employees;
    }
    public function get_offboarded_employees_count()
    {
        $count = $this->db->query("
            SELECT COUNT(*) AS total
            FROM employees
            LEFT JOIN departments
                ON employees.department_id = departments.id
            WHERE employees.onboarded = 0
            AND employees.deleted_at IS NULL
            AND departments.deleted_at IS NULL
        ")->getRow()->total;

        return (int) $count;
    }




    public function get_onboarded_employees()
    {
        $employees = $this->db->query("
            SELECT `employees`.*,  TRIM(CONCAT_WS(' ', first_name, middle_name, last_name)) AS name, `departments`.`name` AS `department_name`
            FROM `employees` 
            LEFT JOIN `departments`
            ON `employees`.`department_id` = `departments`.`id` AND `departments`.`deleted_at` IS NULL
            WHERE `employees`.`onboarded` = 1 
            AND `employees`.`deleted_at` IS NULL"
        )->getResult();

        return $employees;
    }

    public function get_onboarded_employees_count()
    {
        $count = $this->db->query("
            SELECT COUNT(*) AS total
            FROM employees
            LEFT JOIN departments
                ON employees.department_id = departments.id
            WHERE employees.onboarded = 1
            AND employees.deleted_at IS NULL
            AND departments.deleted_at IS NULL
        ")->getRow()->total;

        return (int) $count;
    }

    public function get_departments()
    {
        return $this->db->query("SELECT * FROM `departments` WHERE `deleted_at` IS NULL")->getResult();
    }

    public function onboard_employee($first_name, $middle_name, $last_name, $email, $department_id, $start_date)
    {
        $this->db->query("
            INSERT INTO `employees`
            (
                `first_name`,
                `middle_name`,
                `last_name`,
                `email`,
                `department_id`,
                `start_date`
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )
        ", array(
            $first_name,
            $middle_name,
            $last_name,
            $email,
            $department_id,
            $start_date
        ));

        return $this->db->insertID();
    }

    public function offboard_employee($id)
    {
        return $this->db->query("UPDATE `employees` SET `onboarded` = 0 WHERE `id` = ? AND `deleted_at` IS NULL", array($id));
    }
}