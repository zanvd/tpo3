@extends('layout')

@section('title')
<title>Patronaža</title>
@endsection

@section('content')
<div class="container">
        <div class="jumbotron">
          <h1>Dobrodošli!</h1>
          <p>To je view za načrtovanje obiskov. 
          
          
          <ol>
            @foreach ($obvezniObiski as $visit)
            <li> {{  $visit->work_order->work_order_id  }} je delovni nalog za obisk {{  $visit->visit_date  }} <br> obisk: {{  $visit->visit_subtype->visit_subtype_title  }} pregled je: {{  $visit->visit_subtype->visit_type->visit_type_title}}<br> Pacients: 
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


        </div>
      </div>
@endsection