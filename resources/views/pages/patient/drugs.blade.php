@extends('layouts.app',['title'=>'Drug'])

@section('content')
<section class="content-header">
    <div style="float:right;">
    <a href="{{ route('patient.cart') }}" >
         <i class="fa fa-shopping-cart" style="font-size:35px; "></i>
         <span class="label label-primary" id="cartValue">{{ $total_item }}</span>
      
      </a>
    </div><br><br>
    <div class="input-group input-group-sm" style="clear:both;">
        <input type="text" class="form-control" placeholder="search drug">
            <span class="input-group-btn">
              <button type="button" class="btn btn-info btn-flat">Search</button>
            </span>
      </div>
      <br><br>
    <div class="row">
        @forelse ($drugs as $drug)
        <div class="col-md-4">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-aqua-active">
                <h3 class="widget-user-username">{{ $drug->drugName() }}</h3>
                <h5 class="widget-user-desc">{{ $drug->categoryName() }}</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" src="{{ url('/images/'.$drug->image)}}" alt="{{ $drug->name }}">
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-4 col-sm-offset-4 border-right">
                    <div class="description-block">
                      
                      <p>{{ $drug->side_effect }}</p>
                      <h5 class="description-header">₦{{ $drug->price }}</h5><br>
                      <form>
                      <input type="number" id="quantity_{{ $drug->id }}" value="1" style="width: 50%"><br><br>
     <button class="btn btn-primary" onclick="return addCart({{ $drug->id }})"><span class="description-text">Add Cart</span></button>         
    </form>
    <br>
    <button class="btn btn-primary drugInfo" data-expire="{{ $drug->expire_date}}" data-drug="{{ $drug->drugName() }}" data-manufacturer="{{ $drug->manufacturer}}" data-effect="{{ $drug->side_effect}}" data-dosage="{{ $drug->dosage }}" >More Details</button>
             
    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  
                
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
        @empty
           No drug available 
        @endforelse
                
      </div>
     <center> {{ $drugs->links() }} </center>

</section>
@endsection

@push('scripts')
<script>
    function addCart(drug_id) {
    let quantity=$("#quantity_"+drug_id).val();
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
            url: "{{ route('patient.add-cart') }}",
            type: "POST",
            data: {
                drug_id: drug_id,
                quantity:quantity
            },
            success: function (data) {
              $("#cartValue").text(data.total_item);
               
            }
        });
        return false;
}
$(document).ready(function() {
$("body").on('click','.drugInfo', function(e) {
        $("#modal-default").modal('show');
          let drug = $(this).data('drug');
          let manufacturer = $(this).data('manufacturer');
          let effect = $(this).data('effect');
          let dosage = $(this).data('dosage');
          let expire = $(this).data('expire');
          $('.modal-title').text(drug);
          $('#manufacturer').val(manufacturer);
          $('#effect').val(effect);
          $('#dosage').val(dosage);
          $('#expire_date').val(expire);
      
      });
    });

    </script>
@endpush

@push('modal')
  <!-- begin add address modal-->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
           <div class="box-body">

            <div class="form-group">
              <label for="manufacturer">Manufacturer</label>
              <input type="text" class="form-control" id="manufacturer" readonly>
            </div>
            
            <div class="form-group">
              <label for="expire_date"></label>
              <input type="text" class="form-control" id="expire_date" readonly>
            </div>

            <div class="form-group">
              <label for="effect">Side Effect</label>
              <textarea class="form-control" id="effect" readonly></textarea>
            </div>

            <div class="form-group">
              <label for="dosage">Dosage</label>
              <textarea class="form-control" id="dosage" readonly></textarea>
            </div>

          </div>
        
       
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
   
   </div>
@endpush