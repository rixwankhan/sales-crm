@extends('layouts.admin')
@section('content')
<style>
.horizontal-scrollable > .row { 
	overflow-x: auto; 
	white-space: nowrap; 
}
.card.draggable {
    margin-bottom: 1rem;
    cursor: grab;
}

.droppable {
    background-color: var(--success);
    min-height: 120px;
    margin-bottom: 1rem;
}
.dropzone {
    min-height: 10px; 
    border: 0px solid rgba(0,0,0,0.3);
    /* background: white; */
    padding: 2px 2px;
    margin: 10px 2px;
}
</style>
<div class="card">
    <div class="card-header">
        Kanban 
    </div>

    <div class="card-body">

<div class="container-fluid pt-3 horizontal-scrollable">
    <div class="row flex-row flex-sm-nowrap py-3">
        
        @foreach ($deal_stage as $stage)
            
            <div class="col-sm-6 col-md-4 col-xl-3">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-truncate py-2">{{$stage->name}}</h6>
                    <div class="items border border-light">
                    @foreach ($deals as $deal)
                        @if($deal->stage_id == $stage->id)
                        
                        <div class="card draggable shadow-sm" id="cd<?php echo $deal->id; ?>" draggable="true" ondragstart="drag(event)">
                                <div class="card-body p-2">
                                    <div class="card-title">
                                        <a href="{{ route('admin.deals.show', ['deal' => $deal->id ]) }}" class="lead font-weight-light"><p style="overflow: hidden;">{{ $deal->deal_name }}</p></a><br/>
                                        Source: <strong>{{ $deal->name }} </strong> <br/>
                                        Closing Date: {{ $deal->closing_date }} <br/>
                                        Amount: {{ $deal->amount }} <br/>
                                        Description: <p style="overflow: hidden;">{{ $deal->description }}</p> <br/>
                                    </div>
                                    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.deals.edit', ['deal' => $deal->id ]) }}">Edit Deal</a>
                                </div>
                        </div>
                        <!-- Drop Zone -->
                        <div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
                        @endif
                    @endforeach
                    <!-- Drop Zone -->
                    <div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
</div>

    </div>
</div>


@endsection
@section('scripts')
@parent
<script>
const drag = (event) => {
  event.dataTransfer.setData("text/plain", event.target.id);
}

const allowDrop = (ev) => {
  ev.preventDefault();
  if (hasClass(ev.target,"dropzone")) {
    addClass(ev.target,"droppable");
  }
}

const clearDrop = (ev) => {
    removeClass(ev.target,"droppable");
}

const drop = (event) => {
  event.preventDefault();
  const data = event.dataTransfer.getData("text/plain");
  const element = document.querySelector(`#${data}`);
  try {
    // remove the spacer content from dropzone
    event.target.removeChild(event.target.firstChild);
    // add the draggable content
    event.target.appendChild(element);
    // remove the dropzone parent
    unwrap(event.target);
  } catch (error) {
    console.warn("can't move the item to the same place")
  }
  updateDropzones();
}

const updateDropzones = () => {
    /* after dropping, refresh the drop target areas
      so there is a dropzone after each item
      using jQuery here for simplicity */
    
    var dz = $('<div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>');
    
    // delete old dropzones
    $('.dropzone').remove();

    // insert new dropdzone after each item   
    dz.insertAfter('.card.draggable');
    
    // insert new dropzone in any empty swimlanes
    $(".items:not(:has(.card.draggable))").append(dz);
};

// helpers
function hasClass(target, className) {
    return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
}

function addClass(ele,cls) {
  if (!hasClass(ele,cls)) ele.className += " "+cls;
}

function removeClass(ele,cls) {
  if (hasClass(ele,cls)) {
    var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
    ele.className=ele.className.replace(reg,' ');
  }
}

function unwrap(node) {
    node.replaceWith(...node.childNodes);
}

</script>
@endsection