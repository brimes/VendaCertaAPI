<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Venda certa</title>

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="node_modules/material-components-web/dist/material-components-web.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <style>
        .mdc-typography {
            margin: 0px;
        }
        .mdc-list-item__end-detail {
            width: auto;
        }
        .mdc-list-item {
            border-bottom: 1px solid #ccc;
        }
        </style>

    </head>
    <body class='mdc-typography'>
        <header class="mdc-toolbar">
          <div class="mdc-toolbar__row">
            <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
              <a href="#" class="material-icons mdc-toolbar__icon--menu">menu</a>
              <span class="mdc-toolbar__title">Venda Certa</span>
            </section>
          </div>
        </header>
        <main>
            <div class='mdc-layout-grid'>
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">
                        <div class="mdc-list-group">
                            <h3 class="mdc-list-group__subheader">Vendas</h3>
                            <ul class="mdc-list mdc-list--two-line mdc-list--avatar-list two-line-avatar-text-icon-demo ">
                                @foreach ($sales as $sale)
                                    <li class="mdc-list-item mdc-ripple-upgraded">
                                        <span class="mdc-list-item__start-detail grey-bg" role="presentation">
                                          <i class="material-icons status-icon" aria-hidden="true"> {{  (empty($sale['status']) ? "help_outline" : $statusIcon[$sale['status']]) }}</i>
                                        </span>
                                        <span class="mdc-list-item__text">
                                            {{ (empty($sale['date']) ? "Desconhecido" :  $sale['date']) }} - Nº {{ (empty($sale['code']) ? "Desconhecido" :  $sale['code']) }}
                                            <span class="mdc-list-item__text__secondary status-label">{{ (empty($sale['status']) ? "Em análise" :  $sale['status']) }}</span>
                                        </span>
                                        <span class='mdc-list-item__end-detail' data='{{ json_encode($sale) }}'>
                                            <button class="mdc-button aprovar-venda">
                                                Aprovar
                                            </button>
                                            <button class="mdc-button recusar-venda">
                                                Recusar
                                            </button>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>    
                    </div>
                </div>
            </div>
        </main>
    </body>
    <script>
        $(document).ready(function () {
            $('.aprovar-venda').click(function () {
                let self = this
                let saleData = JSON.parse($(this).parent().attr('data'));

                $.ajax({
                  url:"{{ url('/api/query') }}",
                  type:"POST",
                  contentType:"application/graphql",
                  data: 'mutation update { updateSale (id: "' + saleData.id + '", status: "Válida") {id, status} }',
                  dataType:"json",
                  success: function () {
                    $(self).parent().parent().find('.status-label').html("Válida");
                    $(self).parent().parent().find('.status-icon').html("done");
                  }
                }) 
            });
            $('.recusar-venda').click(function () {
                let self = this
                let saleData = JSON.parse($(this).parent().attr('data'));

                $.ajax({
                  url:"{{ url('/api/query') }}",
                  type:"POST",
                  contentType:"application/graphql",
                  data: 'mutation update { updateSale (id: "' + saleData.id + '", status: "Inválida") {id, status} }',
                  dataType:"json",
                  success: function () {
                    $(self).parent().parent().find('.status-label').html("Inválida");
                    $(self).parent().parent().find('.status-icon').html("block");
                  }
                }) 
            });
        });
    </script>
</html>
