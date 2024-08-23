<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">News Moderation</h2>

    @if($news->isEmpty())
        <p>No pending news for moderation.</p>
    @else
        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">Title</th>
                <th class="py-2 px-4 border-b">Summary</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($news as $item)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $item->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $item->summary }}</td>
                    <td class="py-2 px-4 border-b">
                        <button wire:click="approve({{ $item->id }})" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Approve</button>
                        <button wire:click="reject({{ $item->id }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Reject</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
