<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nom du produit
                </th>
                <th scope="col" class="px-6 py-3">
                    Date d'achat
                </th>
                <th scope="col" class="px-6 py-3">
                    Quantite
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($bonde->type === 'entry')
                @foreach ($bonde->entries as $entry)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $entry->product->name }}"
                        </th>
                        <td class="px-6 py-4">
                            {{ $entry->date_achat }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $entry->quantity }}
                        </td>
                    </tr>
                @endforeach
            @else
                @foreach ($bonde->sorties as $sorty)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $sorty->product->name }}"
                        </th>
                        <td class="px-6 py-4">
                            {{ $sorty->date_vente }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $sorty->quantity }}
                        </td>
                    </tr>
                @endforeach
            @endif


        </tbody>
    </table>
</div>
