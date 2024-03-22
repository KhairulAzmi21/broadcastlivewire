<div>
    <div style="display:flex;justify-content: space-between">
        <a href="/create">Create Baru</a>
        <span wire:poll.1000ms>
            Live Score Fake People : <span style="color:darkblue;">{{ \App\Models\User::get()->count() }}</span> <i
                class="fa-solid fa-heart fa-beat" style="color:palevioletred"></i>
            <br>
            <span>Latest Fake People : <span style="color:darkgoldenrod;">
                    {{ \App\Models\User::latest()->first()->name }}</span></span>
        </span>
    </div>

    <table style="width:100%">
        <thead>
            <tr>
                <th>Broadcast ID</th>
                <th>Status</th>
                <th>Ready to schedule</th>
                <th>Total Success</th>
                <th>Action</th>
                <th>Schedule At</th>
                <th>Schedule Time</th>
                <th>Interval</th>
            </tr>
        </thead>
        <tbody wire:poll.1000ms>

            @foreach ($broadcasts as $broadcast)
                <tr>
                    <td>{{ $broadcast->id }}</td>
                    <td>
                        <div style="display:flex;gap:1rem">
                            @if ($broadcast->status == 'in progress')
                                <i class="fa-solid fa-spinner fa-spin"></i>
                            @endif
                            <span>{{ $broadcast->status }}</span>
                        </div>
                    </td>
                    <td>
                        {{ $broadcast->recipients->whereNotNull('schedule_at')->count() }} /
                        {{ $broadcast->fake_count }}
                        <br>
                        @if ($broadcast->recipients->whereNotNull('schedule_at')->isNotEmpty() && $broadcast->status == 'in progress')
                            <span
                                style="color:darkcyan">{{ \Carbon\Carbon::parse($broadcast->recipients->whereNotNull('schedule_at')->last()->schedule_at)->diffForHumans() }}</span>
                        @endif
                    </td>
                    <td>
                        {{ $broadcast->recipients->whereNotNull('transferred_at')->count() }} /
                        {{ $broadcast->fake_count }}
                        <br>
                        {{-- @if ($broadcast->recipients->whereNotNull('transferred_at')->isNotEmpty() && $broadcast->status == 'in progress')
                            )
                            Latest :
                            {{ \Carbon\Carbon::parse($broadcast->recipients->whereNotNull('transferred_at')->last()->transferred_at)->diffForHumans() }}
                        @endif --}}
                    </td>
                    <td>
                        <button
                            wire:click="action({{ $broadcast->id }}, '{{ $broadcast->status == 'in progress' ? 'stop' : 'start' }}')">{{ $broadcast->status == 'in progress' ? 'Pause' : 'Start' }}</button>

                    </td>
                    <td>{{ $broadcast->schedule_at }}</td>
                    <td>{{ collect($broadcast->schedule_time)->implode(',') }}</td>
                    <td>{{ collect($broadcast->interval)->implode(' to ') }} seconds</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
