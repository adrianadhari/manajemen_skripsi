<x-filament-panels::page>
    <x-filament::section>
        <div>
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>{{ $this->user->name }}</strong></td>
                </tr>
                <tr>
                    <td>NPM</td>
                    <td>:</td>
                    <td><strong>{{ $this->user->no_induk }}</strong></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><strong>{{ $this->user->email }}</strong></td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td><strong>{{ $this->user->kelas }}</strong></td>
                </tr>
                </tr>
                <tr>
                    <td>No. HP</td>
                    <td>:</td>
                    <td><strong>{{ $this->user->no_hp ?? '-' }}</strong></td>
                </tr>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
