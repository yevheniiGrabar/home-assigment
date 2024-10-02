<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Record;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any records.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the record.
     *
     * @param Employee $employee
     * @param User $user
     * @param Record $record
     * @return bool
     */
    public function view(Employee $employee,User $user, Record $record)
    {
        if ($employee->id === $record->employee_id) {
            return true;
        }

        return $user->role_id === 1 && $record->employee->manager_id === $user->id;
    }

    /**
     * Determine whether the user can create records.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->role() === '2';
    }

    /**
     * Determine whether the user can update the record.
     *
     * @param User $user
     * @param Employee $employee
     * @param Record $record
     * @return bool
     */
    public function update(User $user, Employee $employee,Record $record): bool
    {
        if ($employee->id === $record->employee_id) {
            return true;
        }
        return $user->role_id === 1 && $record->employee->manager_id === $user->id;
    }

    /**
     * Determine whether the user can delete the record.
     *
     * @param User $user
     * @param Record $record
     * @return bool
     */
    public function delete(User $user, Record $record): bool
    {
        return $user->role() === '1' || $user->id === $record->employee()->manager_id;
    }

    /**
     * Determine whether the user can view records created by employees of a manager.
     *
     * @param User $user
     * @return bool
     */
    public function viewByManager(User $user): bool
    {
        return $user->role() === '1';
    }
}
