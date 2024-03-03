<!-- begin::Card-->
<div class="card card-custom overflow-hidden">
    <div class="card-body p-0">
        <!-- begin: Invoice-->
        <!-- begin: Invoice header-->
        <div id="container" class="w-full">
            <div class="px-40 pt-20" id="test">
                <div class="flex justify-between">
                    <div style="float: left; " id="left">
                        <h3 class="font-weight-boldest">De:</h3>
                        <div>
                            <p>Layan cosmetics </p>
                            <p>Antananarivo</p>
                            <p>Telephone : 032 69 206 94 </p>
                            <p>Adresse : Lot IIH 61 FNN Tanjombato </p>
                        </div>
                    </div>
                    <div style="float: right; " id="right">
                        <h3 class="font-weight-boldest mb-3">Facture vente a : </h3>
                        <div>
                            <p>{{ $facture->client_name }}</p>
                            <p>Antananarivo</p>
                            <p>Telephone : {{ $facture->phone }} </p>
                            <p>Adresse : {{ $facture->address }} </p>
                        </div>
                    </div>
                </div>
                <div class="border-bottom w-100"></div>
                <div class="d-flex justify-content-between pt-6">
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">Date:</span>
                        <span class="opacity-70">{{ $facture->date }}</span>
                    </div>
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">Facture numero:</span>
                        <span class="opacity-70">{{ $facture->code }}</span>
                    </div>
                </div>
                <div class="d-flex w-full flex-row-reverse">
                    <a href="" data-toggle="modal" data-target="#exampleModalLong"
                        class="text-gray-800 btn btn-primary" id="text-ajout">Ajouter une autre produit</a>
                </div>

                <div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog"
                    aria-labelledby="staticBackdrop" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter une produit</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                @livewire('form-content', ['facture' => $facture])

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: Invoice header-->
        @if (isset($data['contents']))
            <!-- begin: Invoice body-->
            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pl-0 font-weight-bold text-muted text-uppercase">Nom de la produit</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Qty</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Prix</th>
                                    <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0 ;@endphp
                                @foreach ($data['contents'] as $key => $content)
                                    <tr class="font-weight-boldest {{ $key !== 0 ?? 'border-bottom-0' }}">
                                        <td class="pl-0 pt-7">{{ $content['name'] }}</td>
                                        <td class="text-right pt-7">{{ $content['qty'] }}</td>
                                        <td class="text-right pt-7">{{ $content['price'] }} Ar</td>
                                        <td class="text-danger pr-0 pt-7 text-right">
                                            {{ $content['qty'] * $content['price'] }} Ar</td>
                                    </tr>
                                    @php $total+= $content['qty'] *  $content['price'];  @endphp
                                @endforeach

                                <tr class="font-weight-boldest border-bottom-0 mb-4 text-end">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="mb-4">Total : {{ $total }} Ar</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end: Invoice body-->
        @endif

        <!-- begin: Invoice action-->
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0" id="footer-pdf">
            <div class="col-md-9">
                <div class="d-flex justify-content-between">
                    <a href="{{route('factures.index')}}" class="btn btn-light-primary font-weight-bold">Valider</a>
                    <button type="button" class="btn btn-primary font-weight-bold"
                        onclick="window.print()">Imprimer</button>
                </div>
            </div>
        </div>
        <!-- end: Invoice action-->
        <!-- end: Invoice-->
        <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
    </div>
</div>


<!-- end::Card-->
