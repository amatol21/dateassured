<?php

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use Illuminate\Pagination\Paginator;

/**
 * @var $complaints Complaint[]|Paginator
 */
?>

@extends('admin.index')

@section('adminContent')
    <style>
        .complaints_item_status {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border-radius: 1rem;
            background-color: #ccc;
            flex-shrink: 0;
        }
        .complaints_item_status.status-0 {
            background-color: var(--color-red);
        }
        .complaints_item_status.status-1 {
            background-color: var(--color-orange);
        }
        .complaints_item_status.status-2 {
            background-color: var(--color-green);
        }
    </style>
    <div id="articles-list" class="articles-list pad">
        <h2 class="account_title mb-2">Complaints</h2>

        <form action="{{ route('admin.complaints', [], false) }}" id="articles-filter"
              class="articles-filter mb-2 pl-2 pr-2">
            <select name="status" class="input input-small status-select">
                <option value="" @if(request()->get('status') === '') selected @endif>Any status</option>
                <option value="{{ ComplaintStatus::NEW->value }}"
                        @if(request()->get('status') === ''.ComplaintStatus::NEW->value) selected @endif>New
                </option>
                <option value="{{ ComplaintStatus::RESOLVING->value }}"
                        @if(request()->get('status') === ''.ComplaintStatus::RESOLVING->value) selected @endif>In progress
                </option>
                <option value="{{ ComplaintStatus::RESOLVED->value }}"
                        @if(request()->get('status') === ''.ComplaintStatus::RESOLVED->value) selected @endif>Resolved
                </option>
            </select>
            <input type="text" name="subject" placeholder="Subject..." value="{{ request()->get('subject', '') }}"
                   class="input input-small">
            <button type="submit" class="btn btn-small btn-pink">Search</button>
        </form>

        @if($complaints->count() > 0)
            <table id="articles-table" class="pl-2 pr-2 w-100">
                <thead>
                <tr>
                    <th data-sort="title">Subject</th>
                    <th data-sort="author_id" class="center">Creator</th>
                    <th data-sort="status" class="center">Status</th>
                    <th data-sort="created_at" class="center">Created</th>
                    <th style="width: 3rem"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($complaints as $complaint)
                    <tr data-id="{{ $complaint->id }}">
                        <td>
                            <div class="articles_item_title">{{ $complaint->subject }}</div>
                        </td>

                        <td class="center">
                            <a href="{{ route('admin.users.edit', ['id' => $complaint->creator_id], []) }}">{{ $complaint->creator->getFullName() }}</a>
                        </td>

                        <td class="center">
                            <div class="complaints_item_status status-{{ $complaint->status }}"
                                 title="{{ $complaint->status === ComplaintStatus::NEW
                                    ? 'New'
                                    : ($complaint->status === ComplaintStatus::RESOLVED ? 'Resolved' : 'In progress') }}">
                            </div>
                        </td>

                        <td class="center">
                            {{ $complaint->created_at }}
                        </td>

                        <td>
                            <div class="flex ai-center ml-auto">
                                @php
                                    $payload = ['id' => $complaint->id, 'subject' => $complaint->subject];
                                    $options = [
                                        'view-complaint' => ['label' => 'View details', 'payload' => $payload],
                                    ];
                                    if ($complaint->status === ComplaintStatus::NEW) {
                                        $options['make-complaint-resolving'] = ['label' => 'Mark as "In progress"', 'payload' => $payload];
                                    } else if ($complaint->status === ComplaintStatus::RESOLVING) {
                                        $options['make-complaint-resolved'] = ['label' => 'Mark as "Resolved"', 'payload' => $payload];
                                    } else {
                                        $options['cancel-resolved-complaint-status'] = ['label' => 'Mark as "In progress"', 'payload' => $payload];
                                    }
                                    $options['delete-complaint'] = ['label' => 'Delete', 'payload' => $payload];
                                @endphp
                                @include('common.ui.dotsMenu', ['options' => $options])
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>


            @if($complaints->hasPages())
                <div class="p-2">
                    {{ $complaints->appends($_GET)->links('common.ui.pagination') }}
                </div>
            @endif

        @else

            <div class="no-data-msg">
                <div class="no-data-msg_title">Nothing found by your request</div>
                <div class="no-data-msg_hint">Try to change your request and try again.</div>
            </div>

        @endif
    </div>


    <script>
        (() => {
            initTableSorting('#articles-table', '#articles-filter');

            async function applyToComplaint(complaintId, action) {
                try {
                    let data = {
                        _token: '{{ csrf_token() }}',
                        id: complaintId,
                    };
                    let res = await fetch('/admin/complaints/' + action, {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: {'Content-Type': 'application/json'}
                    });
                    if (res.ok) {
                        return true;
                    }
                } catch (e) {
                    console.error(e);
                }
                return false;
            }

            // Delete
            document.addEventListener('delete-complaint', async e => {
                if (confirm('Are you really want to delete complaint "' + (e.detail.subject.slice(0, 50) + '...') + '"?')) {
                    let res = await applyToComplaint(e.detail.id, 'delete');
                    if (res) window.location.reload();
                }
            });

            // Make "In progress"
            document.addEventListener('make-complaint-resolving', async e => {
                if (confirm('Do you want to set complaint status to "In progress"?')) {
                    let res = await applyToComplaint(e.detail.id, 'make-resolving');
                    if (res) window.location.reload();
                }
            });

            // Make "Resolved"
            document.addEventListener('make-complaint-resolved', async e => {
                if (confirm('Do you want to set complaint status to "Resolved"?')) {
                    let res = await applyToComplaint(e.detail.id, 'make-resolved');
                    if (res) window.location.reload();
                }
            });

            // Roll back to "In progress"
            document.addEventListener('cancel-resolved-complaint-status', async e => {
                if (confirm('Do you want to mark complaint as "In progress" again?')) {
                    let res = await applyToComplaint(e.detail.id, 'make-resolving');
                    if (res) window.location.reload();
                }
            });

            // Edit
            document.addEventListener('view-complaint', async e => {
                window.location = '/admin/complaints/view/' + e.detail.id;
            });
        })();
    </script>
@endsection
