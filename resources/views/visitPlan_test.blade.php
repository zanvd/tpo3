@extends('layout')

@section('title')
<title>Patronaža</title>
@endsection

@section('content')
<div class="container">
        <div class="jumbotron">
          <h1>Dobrodošli!</h1>
          <p>To je view za načrtovanje obiskov. </p>

          <p> {{  $plani  }} </p>
          <h4>Obiski obvezni brez plana </h4>
          <ol>
            @foreach ($obvezniBrezPlana as $visit)
            <li> {{  $visit->visit_id  }} je id obiska ki pripada delovnemu nalogu {{  $visit->workOrderId  }} je delovni nalog za obisk {{  $visit->plannedDate  }} <br> obisk: {{  $visit->visitTitle }} pregled je: {{  $visit->work_order->visitSubtype->visit_type->visit_type_title}}<br> Pacients:
              <ul>
              @foreach($visit->patients as $patient)
                  <li>{{  $patient->person->name  }}</li>
              @endforeach
              </ul>
            </li>
            @endforeach
          </ol>

          <h4>Obiski obvezni v planu </h4>
          <ol>
            @foreach ($obvezniVPlanu as $visit)
            <li> {{  $visit->visit_id  }} je id obiska ki pripada delovnemu nalogu {{  $visit->workOrderId  }} je delovni nalog za obisk {{  $visit->plannedDate  }} <br> obisk: {{  $visit->visitTitle }} pregled je: {{  $visit->work_order->visitSubtype->visit_type->visit_type_title}}<br> Pacients:
              <ul>
              @foreach($visit->patients as $patient)
                  <li>{{  $patient->person->name  }}</li>
              @endforeach
              </ul>
            </li>
            @endforeach
          </ol>

          <h4>Obiski okvirni brez plana </h4>
          <ol>
            @foreach ($okvirniBrezPlana as $visit)
            <li> {{  $visit->visit_id  }} je id obiska ki pripada delovnemu nalogu {{  $visit->workOrderId  }} je delovni nalog za obisk {{  $visit->plannedDate  }} <br> obisk: {{  $visit->visitTitle }} pregled je: {{  $visit->work_order->visitSubtype->visit_type->visit_type_title}}<br> Pacients:
              <ul>
              @foreach($visit->patients as $patient)
                  <li>{{  $patient->person->name  }}</li>
              @endforeach
              </ul>
            </li>
            @endforeach
          </ol>

          <h4>Obiski okvirni v planu </h4>
          <ol>
            @foreach ($okvirniVPlanu as $visit)
            <li> {{  $visit->visit_id  }} je id obiska ki pripada delovnemu nalogu {{  $visit->workOrderId  }} je delovni nalog za obisk {{  $visit->plannedDate  }} <br> obisk: {{  $visit->visitTitle }} pregled je: {{  $visit->work_order->visitSubtype->visit_type->visit_type_title}}<br> Pacients:
              <ul>
              @foreach($visit->patients as $patient)
                  <li>{{  $patient->person->name  }}</li>
              @endforeach
              </ul>
            </li>
            @endforeach
          </ol>

          
          
          
      
        </div>
      </div>
@endsection