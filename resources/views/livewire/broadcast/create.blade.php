<div>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:brown">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    {{-- In work, do what you enjoy. --}}
    <form wire:submit="save">
        <div>
            <label for="">Broadcast Name</label>
            <input type="text" wire:model="name" style="width: 100%">
        </div>
        <div>
            <label for="">Berapa Banyak Data nak Fake?</label>
            <input type="number" wire:model="fake_count" style="width: 100%">
        </div>
        <div>
            <label for="">Schedule at</label>
            <input type="datetime-local" wire:model="schedule_at" style="width: 100%">
        </div>
        <div>
            <label for="">Schedule Time</label>
            <select wire:model="schedule_time" multiple style="width: 100%">
                @for ($i = 0; $i < 24; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label for="">Interval <sup style="color:cornflowerblue">e.g 10,30 for 10 to 30
                    seconds</sup></label>

            <input type="text" wire:model="interval" style="width: 100%">

        </div>
        <button type="submit">Create Broadcast 🥳</button>
    </form>
</div>
