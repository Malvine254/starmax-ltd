@extends('admin.layout')
@section('page-title', 'Contact Messages')

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Email</th>
                <th>Service</th>
                <th>Source</th>
                <th>Received</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
                <tr>
                    <td>
                        @if($message->read_at)
                            <span class="badge badge-gray">Read</span>
                        @else
                            <span class="badge badge-blue">New</span>
                        @endif
                    </td>
                    <td>{{ $message->name }}</td>
                    <td><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></td>
                    <td>{{ $message->service ? str($message->service)->headline() : 'General' }}</td>
                    <td><span class="badge badge-gray">{{ $message->source === 'grace-portfolio' ? 'Grace Portfolio' : 'Starmax Website' }}</span></td>
                    <td>{{ $message->created_at->format('M d, Y H:i') }}</td>
                    <td><a href="{{ route('admin.contact-messages.show', $message) }}" class="btn btn-secondary">Open</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="color:#64748b;">No contact messages yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $messages->links() }}
</div>
@endsection
