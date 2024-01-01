<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <link rel="stylesheet" href="{{asset('pdf/style.css')}}" media="all" />
  </head>
  <body>
    <header class="clearfix">
      {{-- <div id="logo">
        <img src="logo.png">
      </div> --}}
      <h1>Lyan cosmetics</h1>
      <div id="company" class="clearfix">
        <div>Lyan cosmetics</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="lyancosmetics@gmail.com">lyancosmetics@gmail.com</a></div>
      </div>
      <div id="project">
        <div><span>PROJECT</span> Website development</div>
        <div><span>CLIENT</span>{{$record->client_name}}</div>
        <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
        <div><span>EMAIL</span> <a href="{{$record->email}}">{{$record->email}}</a></div>
        <div><span>DATE</span>{{$record->date}}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">NOM</th>
            <th class="desc">DESCRIPTION</th>
            <th>PRIX</th>
            <th>QTY</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @php
            $grandTotal = 0; // Initialisation de la variable du grand total
          @endphp
          @foreach ($record->contents as $content)
          <tr>
            <td class="service">{{$content->name}}</td>
            <td class="desc">{{$content->description}}</td>
            <td class="unit">{{$content->price}} Ariary</td>
            <td class="qty">{{$content->qty}}</td>
            @php
              $total = $content->price * $content->qty; // Calcul du total pour cette ligne
              $grandTotal += $total; // Ajout du total au grand total
            @endphp
            <td class="total">{{$content->price * $content->qty}} Ariary</td>
          </tr>
          @endforeach
       
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
      <div id="notices" style="float: right;">
        <div>GRAND TOTAL: {{$grandTotal}} Ariary</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>