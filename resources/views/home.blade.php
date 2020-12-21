@extends('layouts.app')

@section('title', 'Home')


@section('content')

<div class="row itinerary">
    <div class="col-md-12 col-sm-12 text-left">
        <button class="btn btn-dark" id="getItinerary">Generate Itinerary</button>
    </div>
</div>
<div class="row itinerary">
    <ol class="col-md-12 col-sm-12" id="itinerary">
    </ol>
</div>


<script>
    $(document).ready(function() {
        $(document).on('click', '#getItinerary', function() {
            $.post("/getItinerary", {}, function(data) {
                console.log(data);
                let json = JSON.parse(data);
                if (json.success) {
                    let taskHtml = `<li style="font-weight:bold">Start</li>`;
                    json.data.forEach(function(task) {
                        taskHtml += templateRow(task);
                    });
                    taskHtml += `<li style="font-weight:bold">Final destination reached!</li>`;
                    $("#itinerary").html(taskHtml);
                }
            });
        });
    });

    function templateRow(ticket) {
        return `<li>${ticket}</li>`;
    }
</script>

@endsection