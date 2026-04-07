@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Contact Message Details</h4>
                            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Back to Contacts
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Contact Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Name:</th>
                                                <td><strong>{{ $contact->first_name }} {{ $contact->last_name }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                                            </tr>
                                            <tr>
                                                <th>Phone:</th>
                                                <td><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td>
                                                    @if($contact->status == 'new')
                                                        <span class="badge badge-warning">New</span>
                                                    @elseif($contact->status == 'read')
                                                        <span class="badge badge-info">Read</span>
                                                    @elseif($contact->status == 'replied')
                                                        <span class="badge badge-success">Replied</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Date:</th>
                                                <td>{{ $contact->created_at->format('F d, Y h:i A') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Update Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('admin.contacts.updateStatus', $contact->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="new" {{ $contact->status == 'new' ? 'selected' : '' }}>New</option>
                                                    <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Read</option>
                                                    <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Replied</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Message</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $contact->message }}</p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this contact message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="mdi mdi-delete"></i> Delete Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

