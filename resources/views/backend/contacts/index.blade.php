@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Contact Messages</h4>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contacts ?? [] as $contact)
                                        <tr class="{{ $contact->status == 'new' ? 'table-warning' : '' }}">
                                            <td>{{ $contact->id }}</td>
                                            <td>
                                                <strong>{{ $contact->first_name }} {{ $contact->last_name }}</strong>
                                            </td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->phone }}</td>
                                            <td>
                                                <small>{{ Str::limit($contact->message, 50) }}</small>
                                            </td>
                                            <td>
                                                @if($contact->status == 'new')
                                                    <span class="badge badge-warning">New</span>
                                                @elseif($contact->status == 'read')
                                                    <span class="badge badge-info">Read</span>
                                                @elseif($contact->status == 'replied')
                                                    <span class="badge badge-success">Replied</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $contact->created_at->format('M d, Y') }}
                                                <br><small class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="d-grid gap-3">
                                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="View">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this contact message?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <p class="text-muted mb-0">No contact messages found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($contacts) && $contacts->hasPages())
                            <div class="mt-4">
                                {{ $contacts->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

