<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{$ppto->folio}}</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: 8px;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: 8px;
    }
    .gray {
        background-color: lightgray
    }

    @page {
        margin: {{$ppto->margin}}px !important;
    }

    .test{
      /* color:#00017f */
      /* color:#d6360e; */
      background-color:#09f87d;
      border: 1px solid;
    }

    .titulo-cabezal{
      margin: 0px;
      font-family: 'Times New Roman', Times, serif;
      font-size: 45px;
    }

    .texto-cabezal{
      margin: 0px;
      font-family: 'Times New Roman', Times, serif;
      font-size: 18px;
    }
    
    .texto{
      font-size: 14px;
      margin: 3px;
    }

    .tabla-conceptos{
      font-size: 12px;
    }

    #watermark {
      text-align: center;
      position: fixed;
      bottom:   10cm;
      /* left:     5.5cm; */
      width:    15cm;
      height:   8cm;
      z-index:  -1000;
      transform: rotate(-45deg);
      font-size: 70px;
    }

    header {
      /* position: fixed; */
    }
</style>

</head>
@php
  $color = '#00017f';
  $header = json_decode($ppto->header);
@endphp
<body style="margin: 10px;">

  {{-- CABEZAL --}}
  <header>
    <div>
      <table width="100%">
        <tr>
          <td align="right" style="padding-top: 10px; padding-left: 50px; vertical-align: top;">
            <div class="logo">
              <img width="80px" src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/4QCORXhpZgAATU0AKgAAAAgABQESAAMAAAABAAEAAAEaAAUAAAABAAAASgEbAAUAAAABAAAAUgEoAAMAAAABAAIAAIdpAAQAAAABAAAAWgAAAAAAAABIAAAAAQAAAEgAAAABAAOQAAAHAAAABDAyMTCgAAAHAAAABDAxMDCgAQADAAAAAf//AAAAAAAAAAD/4QS+aHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49J++7vycgaWQ9J1c1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCc/Pg0KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyI+DQoJPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4NCgkJPHJkZjpEZXNjcmlwdGlvbiB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyI+DQoJCQk8ZXhpZjpPcmllbnRhdGlvbj5Ub3AtbGVmdDwvZXhpZjpPcmllbnRhdGlvbj4NCgkJCTxleGlmOlhSZXNvbHV0aW9uPjcyPC9leGlmOlhSZXNvbHV0aW9uPg0KCQkJPGV4aWY6WVJlc29sdXRpb24+NzI8L2V4aWY6WVJlc29sdXRpb24+DQoJCQk8ZXhpZjpSZXNvbHV0aW9uVW5pdD5JbmNoPC9leGlmOlJlc29sdXRpb25Vbml0Pg0KCQkJPGV4aWY6Rmxhc2hQaXhWZXJzaW9uPkZsYXNoUGl4IFZlcnNpb24gMS4wPC9leGlmOkZsYXNoUGl4VmVyc2lvbj4NCgkJCTxleGlmOk9yaWVudGF0aW9uPlRvcC1sZWZ0PC9leGlmOk9yaWVudGF0aW9uPg0KCQkJPGV4aWY6WFJlc29sdXRpb24+NzI8L2V4aWY6WFJlc29sdXRpb24+DQoJCQk8ZXhpZjpZUmVzb2x1dGlvbj43MjwvZXhpZjpZUmVzb2x1dGlvbj4NCgkJCTxleGlmOlJlc29sdXRpb25Vbml0PkluY2g8L2V4aWY6UmVzb2x1dGlvblVuaXQ+DQoJCQk8ZXhpZjpGbGFzaFBpeFZlcnNpb24+Rmxhc2hQaXggVmVyc2lvbiAxLjA8L2V4aWY6Rmxhc2hQaXhWZXJzaW9uPg0KCQkJPGV4aWY6T3JpZW50YXRpb24+VG9wLWxlZnQ8L2V4aWY6T3JpZW50YXRpb24+DQoJCQk8ZXhpZjpYUmVzb2x1dGlvbj43MjwvZXhpZjpYUmVzb2x1dGlvbj4NCgkJCTxleGlmOllSZXNvbHV0aW9uPjcyPC9leGlmOllSZXNvbHV0aW9uPg0KCQkJPGV4aWY6UmVzb2x1dGlvblVuaXQ+SW5jaDwvZXhpZjpSZXNvbHV0aW9uVW5pdD4NCgkJCTxleGlmOkV4aWZWZXJzaW9uPkV4aWYgVmVyc2lvbiAyLjE8L2V4aWY6RXhpZlZlcnNpb24+DQoJCQk8ZXhpZjpGbGFzaFBpeFZlcnNpb24+Rmxhc2hQaXggVmVyc2lvbiAxLjA8L2V4aWY6Rmxhc2hQaXhWZXJzaW9uPg0KCQkJPGV4aWY6Q29sb3JTcGFjZT5VbmNhbGlicmF0ZWQ8L2V4aWY6Q29sb3JTcGFjZT4NCgkJPC9yZGY6RGVzY3JpcHRpb24+DQoJPC9yZGY6UkRGPg0KPC94OnhtcG1ldGE+DQo8P3hwYWNrZXQgZW5kPSd3Jz8+/9sAQwACAQECAQECAgICAgICAgMFAwMDAwMGBAQDBQcGBwcHBgcHCAkLCQgICggHBwoNCgoLDAwMDAcJDg8NDA4LDAwM/9sAQwECAgIDAwMGAwMGDAgHCAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwM/8AAEQgBVwD+AwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A/Guiiiv7APzMKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigApr9KdTX6Vy4r+G/kXqOooorqICiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKCrN0Xd9BXLiv4b+RUddAooorqJCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKcjED/EZptG3d3xXLi/4T+RUQooorqJCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiijzAKKKKFrqAUUUUAFFFFABRRRRsVysKAN3T5vpRQPl6Bm6dDiuPFS900oq7CiiiuwxCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKOXoAVNaWc2pXUNvbwyXFxcOI4oolLvK5IAVR1JJIGB3NRlNpDN93OM54J9q/Zj/g3M/4Ir2vxDbSf2gPipo802mw3K3PgrRrlAFvmjKkanImeUVx+5Dj5tjSbSpiY/OcQZ5Sy6h7ST6aLuzswuFlWlZH5eftV/sg+LP2NvEHhHRvGkcNnrnirw1beJvsAJ87Top5riKOGb/pptgDMo+75gHJGa8or9cv+Duf4b2ug/tX/AAt8QRxKtxrHhiexkYE4kFvdvIuckj/l6Yk4ySTkkCvyQK4bPP48EfXtS4bzR4zCxrz3kr/jYeKo+znyDKKeY/mC/Nt9cda9N+BX7GPxa/admt1+H/w58ZeLI7tzGl1p+lzS2YYb87p8CJcbGGWcAlSOxr0cRm2HoK9SSXzMI05y2PL6M4P64zzx1r9Lv2bv+DWf9or4vpHc+M7jwz8M7Fky0d/djUL5Ocf6m33R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ILftct+yd/wUg8ItdTSLoXxCb/hENTj3kI/2uRFtywwfu3CxfM23AZzkDOfiojBqQtmPH3unX2/H+fYdK8vNsvp42g6M/tK39eh1Ua3s5KcT+kL9tb/g5P8Ahr+y3+0NoPgvQY/+Eytbe/8AK8XalYOJotJQyGOSOLBy88bLll5AAxg7ty/Yfxp/as8O3H7Dvi74qaHq1rqnh228KX+uW97Zu0kTwx2kswkUqCScRkEAZBO3qK/j66LjtxxjjAzgcduvpj3NfU37JP8AwVD8Wfs7fso/Fb4K6tcahrngLx94fvLHTLQPltBv5wV82En7sL7naWMcM3zABmdm/OcZ4fRhGEqG8Wr36q61+R7FPNpSb5u2h53+wT+2Brn7CH7WHhH4maI0z/2HdhdStEAP9oWDlVuLfnAy8edpJAVwpycCv6r/AIpftseDfhN+y5cfGK4vpNY8Cw6db6yl5pxjlNxaTNFskXcygj96pBHG0jOK/jsDeWMHGO4xxiv02+CP/BQdfHf/AAb8fGH4O6hqUn/CWeA4rEafC82Z7zRrnWbNDs3AkrFLN5TAcIjRqCPlNHEvCqqOlOn0aTfk3b8DLC45wUk/Vep+uHwX/wCDg39ln4yStDD8UNN8N3cZAkg8QQvpaoSWAPmSKIm6clZCOR615x/wXq/an8N+Pf8Agjx8RNQ8E+KtD8QWeuPplml5pl7b3kM8Ut/B5m1lZlw0aupIzyeCD81fzPoct+Hr0H+f508kxtxxyD1P+e5/PPFdGF8PaVKtCvCTTi07PyaHPNpzi4S6oaWz6c/pTTyf89ef8aKK/TKdOMNjxeboFFFFbGYUUUUAFFFFABRRRQAUUUUAFFFLt9xXPif4f3FX0EoooroJCiiigAooooAKKKKACiiigAooooAKO/QUUUabMAq1Y6zdabFdRW9xNDDfRC3uY45CiXUYdZAkgBG5fMRGw2eUU9qq0VEqaasyuZhRRRVkhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRSlsAUUUUwCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKUtgCiiimAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQA1nUBmb7qjJPoKcj5CsrblZRhh3B5BoorP3ubyHpYKKKK0EFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH//Z" />
            </div>
          </td>
          <td style="padding: 0px; vertical-align: top; text-align: center;">
            <div style="padding: 0px; width: 520px;">
              <p class="titulo-cabezal">{{$header->empresa}}</p>
              <pre class="texto-cabezal">{{$header->header}}</pre>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </header>

  <br>
  <div>
    @if (!$ppto->concluido)
    <center>
      <h3 style="color: red;">**PRESUPUESTO NO CONCLUIDO**</h3>
    </center>
    @endif
    
    <p class="texto"><b>CLIENTE:</b> {{strtoupper($ppto->cliente->nombre)}}</p>
    @if ($ppto->contactos->count() > 0)        
    <p class="texto"><b>CONTACTO{{ $ppto->contactos->count() > 1 ? "S" : ""}}:</b>
      @foreach ($ppto->contactos as $item)
          {{$item->contacto->prefijo_nombre_correo}}<br>
      @endforeach
    </p>
    @endif
    <p class="texto"><b>PRESUPUESTO:</b> {{$ppto->folio}}</p>
    <p class="texto"><b>FECHA:</b> {{$ppto->fecha_format}}</p>
    <p class="texto"><b>MONEDA:</b> {{$ppto->moneda}}</p>
  </div>





{{-- CONCEPTOS --}}
<div>
  <br>
  <h5 style="margin: 3px;">PRESUPUESTO POR: {{strtoupper($ppto->titulo)}}</h5>
  <table width="100%" style="border: 1px solid; padding: 0px; margin: 0px; border-spacing: 0px;">
    <thead style="padding: 0px; margin: 0px;">
      <tr style="border: none; background-color: {{$color}}; font-size: 12px; color: white; padding: 0px; margin: 0px;">
        <th>NO.</th>
        <th>DESCRIPCIÓN</th>
        <th>UNI</th>
        <th>CANT</th>
        <th align="center"></th>
        <th>{{$ppto->mostrar_unitarios ? "PU." : ""}}</th>
        <th align="center"></th>
        <th>IMPORTE</th>
      </tr>
    </thead>
    <tbody style="background-color: #fff; border: none;">
      
      @foreach ($ppto->categorias as $categoria)   

        <tr style="font-size: 12px; background-color: rgb(192, 192, 192);">
          <td></td>
          <td style="padding: 5px;" align="center">{{$categoria->nombre}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">$</td>
          <td width="65px" align="right">@float($categoria->total_currency)</td>
        </tr>

        @foreach ($categoria->conceptos as $concepto)
        <tr style="font-size: 11px;">
          <td width="30px" align="center">{{$loop->iteration}}</td>
          <td width="380px" style="padding: 6px;" align="left">{{$concepto->descripcion}}</td>
          <td width="60px" align="center">{{$concepto->unidad_medida}}</td>
          <td width="60px" align="center">{{$concepto->cantidad}}</td>
          <td align="center">{{$ppto->mostrar_unitarios ? "$" : ""}}</td>
          <td width="65px" align="right">{{$ppto->mostrar_unitarios ? number_format($concepto->precio_unitario_currency, 2) : ""}}</td>
          <td align="center">{{$ppto->mostrar_unitarios ? "$" : ""}}</td>
          <td width="65px" align="right">{{$ppto->mostrar_unitarios ? number_format($concepto->total_currency, 2) : ""}}</td>
        </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>


  <table width="100%" style="margin-0px; padding: 0px; border-spacing: 0px;">
    <tr style="vertical-align: top;">
      <td style="font-size: 10px;">
        @if ($ppto->notas)
          <h2>Notas:</h2>
          <p style="white-space: pre-wrap; line-height: 2;">{{$ppto->notas}}</p>
        @endif
        @if ($ppto->atentamente)
          <h2>ATENTAMENTE: {{$ppto->atentamente}}</h2>
        @endif
      </td>
      <td style="padding: 0px; margin: 0px;" align="right;">
        <table style="margin-left:auto; border-spacing: 0px; font-size: 11px; border-bottom: solid 1px; border-right: solid 1px; border-left: solid 1px;">
          @if ($ppto->descuento_cantidad > 0)
          <tr>
            <td width="80px" align="right;" style="padding: 3px; background-color: {{$color}}; color: white;"><b>DESCUENTO:
              @if ($ppto->porcentaje_descuento > 0)
                (@float($ppto->porcentaje_descuento)%)
              @endif</b>
            </td>
            <td width="25px" align="center;">$</td>
            <td width="65px" align="right;">@float($ppto->descuento_currency)</td>
          </tr>
          @endif
          <tr>
            <td width="80px" align="right;" style="padding: 3px; background-color: {{$color}}; color: white;"><b>SUB-TOTAL: </b></td>
            <td width="25px" align="center;">$</td>
            <td width="65px" align="right;">@float($ppto->subtotal_currency)</td>
          </tr>
          <tr>
            <td width="80px" align="right;" style="padding: 3px; background-color: {{$color}}; color: white;"><b>IVA (@float($ppto->tasa_iva)%): </b></td>
            <td width="25px" align="center;">$</td>
            <td width="65px" align="right;">@float($ppto->iva_currency)</td>
          </tr>
          <tr>
            <td width="80px" align="right;" style="padding: 3px; background-color: {{$color}}; color: white;"><b>TOTAL: </b></td>
            <td width="25px" align="center;">$</td>
            <td width="65px" align="right;">@float($ppto->total_currency)</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>



</div>



</body>
</html>