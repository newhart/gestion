<div class="card card-custom overflow-hidden">
    <div class="card-body p-0">
        <!-- begin: Invoice-->
        <!-- begin: Invoice header-->
        <div class="row justify-content-center py-8 px-8 px-md-0">
            <div class="col-md-9">
                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                    <h1 class="display-4 font-weight-boldest mb-10">Lyan cosmetics</h1>
                    <div class="d-flex flex-column align-items-md-end px-0">
                        <!--begin::Logo-->
                        <a href="#" class="mb-5">
                            <img src="assets/media/logos/logo-dark.png" alt="" />
                        </a>
                        <!--end::Logo-->
                        <span class="d-flex flex-column align-items-md-end opacity-70">
                            <span>Cecilia Chapman, 711-2880 Nulla St, Mankato</span>
                            <span>Mississippi 96522</span>
                        </span>
                    </div>
                </div>
                <div class="border-bottom w-100"></div>
                <div class="flex justify-between py-3">
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">Date : </span>
                        <span
                            class="opacity-70">{{ \Carbon\Carbon::parse($bonde->created_at)->format('M d, Y') }}</span>
                    </div>
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">Bande de livraison : </span>
                        <span class="opacity-70">{{ $bonde->num }}</span>
                    </div>

                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">Statuts : </span>
                        @if (!$bonde->status)
                            <span class="opacity-70  bg-gray-500 text-white w-[100px] px-3 pl-7 rounded-xl py-2">En
                                attente</span>
                        @else
                            <span
                                class="opacity-70  bg-green-400 text-white w-[100px] px-3 pl-7 rounded-xl py-2">Valider</span>
                        @endif
                    </div>

                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModalLong">
                            Ajouter le produit
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: Invoice header-->

        <div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un produit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($type === 'entry')
                            @livewire('create-entry')
                        @else
                            @livewire('create-sorty')
                        @endif

                    </div>
                </div>
            </div>
        </div>


        <!-- begin: Invoice body-->
        @if (count($data) > 0)
            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pl-0 font-weight-bold text-muted text-uppercase">Nom du produit</th>
                                    <th class="pl-0 font-weight-bold text-muted text-uppercase">Catégorie</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr class="font-weight-boldest">
                                        <td class="pl-0 pt-7">{{ $item['product_name'] }}</td>
                                        <td class="pl-0 pt-7">{{ $item['category'] }}</td>
                                        <td class="text-right pt-7">{{ $item['quantity'] }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end: Invoice body-->
            <!-- begin: Invoice action-->
            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('achats.list') }}" class="btn btn-light-primary font-weight-bold">Annuler</a>
                        <button type="button" class="btn btn-primary font-weight-bold"
                            wire:click.prevent="click">Valider</button>
                    </div>
                </div>
            </div>
            <!-- end: Invoice action-->
            <!-- end: Invoice-->
        @endif

    </div>
</div>
