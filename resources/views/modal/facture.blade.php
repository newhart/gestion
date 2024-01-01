

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                Nom de la produit
            </th>
            <th scope="col" class="px-6 py-3">
                Prix
            </th>
            <th scope="col" class="px-6 py-3">
                Quantite
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($facture->contents as $content)
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$content->name}}"
                </th>
                <td class="px-6 py-4">
                    {{$content->price}}
                </td>
                <td class="px-6 py-4">
                    {{$content->qty}}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
