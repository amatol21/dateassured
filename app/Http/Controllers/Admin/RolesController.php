<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveRoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RolesController extends Controller
{
    public function list(): View
    {
        return view('admin.roles.list', [
            'roles' => Role::orderBy('name', 'asc')->paginate(25),
        ]);
    }

    public function editForm(Request $request, int $id): View
    {
        $role = Role::where('id', $id)->first();
        if ($role === null) abort(404);
        return view('admin.roles.form', ['role' => $role]);
    }

    public function creationForm(Request $request): View
    {
        return view('admin.roles.form', ['role' => new Role()]);
    }

    public function save(SaveRoleRequest $request): RedirectResponse
    {
        $role = $request->has('id') ? Role::where('id', $request->id)->first() : new Role();
        if ($role === null) abort(404);
        $role->name = $request->name;
        $role->permissions = implode(',', $request->permissions);
        $creating = $role->exists;
        if ($role->save()) {
            Toast::success('Role '.$role->name.' successfully '.($creating ? 'saved.' : 'created.'));
        } else {
            Toast::error('Error occurred on processing your request.');
        }
        return redirect()->route('admin.roles');
    }
}
