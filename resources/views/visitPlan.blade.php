@extends('layout')

@section('title')
<title>Patronaža</title>
@endsection

@section('content')
<div class="container">
        <div class="jumbotron">
          <h1>Dobrodošli!</h1>
          <p>To je view za načrtovanje obiskov. </p>

          
          <h4>Obiski sestra </h4>
          <ol>
            @foreach ($obvezniObiski as $visit)
            <li> {{  $visit->work_order->work_order_id  }} je delovni nalog za obisk {{  $visit->planned_date  }} <br> obisk: {{  $visit->work_order->visitSubtype->visit_subtype_title }} pregled je: {{  $visit->work_order->visitSubtype->visit_type->visit_type_title}}<br> Pacients:
              <ul>
              @foreach($wops as $wop)
                @if($wop->work_order_id == $visit->work_order->work_order_id)
                  <li>{{  $wop->patient->person->name  }}</li>
                @endif
              @endforeach
              </ul>
            </li>
            @endforeach
          </ol>

          {!! $obvezniObiski->render() !!}
          
          
      
        </div>
      </div>
@endsection