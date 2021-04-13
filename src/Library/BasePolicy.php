<?php


namespace Cmdev\NovaModules\Library;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BasePolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Model $model)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Model $model)
    {
        return true;
    }

    public function delete(User $user, Model $model)
    {
        return true;
    }
}
