<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ComplaintStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManageComplaintRequest;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ComplaintsController extends Controller
{
    public function list(): View
    {
        return view('admin.complaints.list', [
            'complaints' => Complaint::orderBy('id', 'desc')->paginate(20),
        ]);
    }

    public function view(Request $request, int $id): View
    {
        $complaint = Complaint::where('id', $id)->first();
        if ($complaint === null) abort(404);
        return view('admin.complaints.details', [
            'complaint' => $complaint
        ]);
    }

    public function makeResolving(ManageComplaintRequest $request)
    {
        $complaint = Complaint::where('id', $request->id)->first();
        if ($complaint === null) abort(404);
        $complaint->status = ComplaintStatus::RESOLVING->value;
        if ($complaint->resolver_id === null) {
            $complaint->resolver_id = Auth::id();
        }
        $complaint->save();
        return response('OK', 200);
    }

    public function makeResolved(ManageComplaintRequest $request)
    {
        $complaint = Complaint::where('id', $request->id)->first();
        if ($complaint === null) abort(404);
        $complaint->status = ComplaintStatus::RESOLVED->value;
        if ($complaint->resolver_id === null) {
            $complaint->resolver_id = Auth::id();
        }
        $complaint->save();
        return response('OK', 200);
    }
}
