<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resturant finder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('public/assets/style.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA89OrYazKAQbDbExoW0LoOxRfDI2fyDuc&libraries=places"></script>
</head>
<body>
<div class="main-body" id="main-body" style="background-image: url({{ asset('public/assets/img/bc.jpg')}})">
    <div class="container">
        <nav class="navbar navbar-expand-lg" style="background-color: transparent">
            <a class="navbar-brand" href="#">Eat<span class="now">now</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" style="justify-content: flex-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="divider"></div>

    <div class="container">
        <div class="search-body" id="search-body">
            <input type="text" id="input" class="form-control custom-input" style="border-right-color: transparent" placeholder="Name Your Food">
            <input type="text" class="form-control custom-input" style="border-left-color: transparent" id="autocomplete-input-from">
            <input type="button" class="btn btn-success"  onclick="search()" style="padding: 21px;border-radius: 0;" value="Search">
        </div>
    </div>
</div>
<div class="list-body">
    <div class="container">
        <div class="spinner-border" id="loader" style="margin: auto; display: none" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="row" id="card-body">

        </div>
    </div>
</div>
<script>
    let from = document.getElementById('autocomplete-input-from');
    let autocomplete_from = new google.maps.places.Autocomplete(from);
    let resturants = [];
    let cardBody = '';
    let searchPlace = null;
    autocomplete_from.addListener('place_changed', function () {
        let place = autocomplete_from.getPlace();
        searchPlace = {
            lat:place.geometry.location.lat(),
            lng:place.geometry.location.lng(),
            formatted_address: place.formatted_address
        };
    })


    function search(){

        cardBody = '';
        $('#card-body').html('');
        $('#main-body').addClass('searched');
        $('#search-body').addClass(' searched-body');
        $('#loader').css('display', 'block');


        $.ajax({
            method: "post",
            data:{
                lat: searchPlace.lat,
                lng: searchPlace.lng,
                formatted_address: searchPlace.formatted_address,
                input: $('#input').val(),
            },
            url: "{{route('api.get_data')}}",
            success: function(res){
                $('#loader').css('display', 'none');
                resturants = res.locations;
                console.log(resturants);
                for (let i = 0; i < resturants.length; i++) {
                    image = resturants[i].storePhotos[0];
                    if (!resturants[i].storePhotos[0]) {
                        image = 'http://lorempixel.com/348/215/food/';
                    }
                    cardBody += `<div class="col-md-4">
                        <div class="card">
                            <img src="${image}" class="card-img-top" alt="..." style="height: 215px;">
                            <div class="card-body">
                                <h5 class="card-title"><b>Name: </b>${resturants[i].details.name}</h5>
                                <p class="card-text"><b>Address: </b>${resturants[i].details.formatted_address}</p>
                                <p class="card-text"><b>Phone: </b>${resturants[i].details.formatted_phone_number}</p>
                            </div>
                        </div>
                    </div>`;
                }
                $('#card-body').html(cardBody);
            }});


        {{--$.ajax({--}}
        {{--    method: "post",--}}
        {{--    data:{--}}
        {{--        lat: searchPlace.lat,--}}
        {{--        lng: searchPlace.lng,--}}
        {{--        formatted_address: searchPlace.formatted_address,--}}
        {{--        input: $('#input').val(),--}}
        {{--    },--}}
        {{--    url: "{{route('api.search-database')}}",--}}
        {{--    success: function(res){--}}
        {{--        $('#loader').css('display', 'none');--}}
        {{--        // resturants = res.locations;--}}
        {{--        console.log(res);--}}
        {{--        return false;--}}
        {{--        for (let i = 0; i < resturants.length; i++) {--}}
        {{--            image = resturants[i].storePhotos[0];--}}
        {{--            if (!resturants[i].storePhotos[0]) {--}}
        {{--                image = 'http://lorempixel.com/348/215/food/';--}}
        {{--            }--}}
        {{--            cardBody += `<div class="col-md-4">--}}
        {{--            <div class="card">--}}
        {{--                <img src="${image}" class="card-img-top" alt="..." style="height: 215px;">--}}
        {{--                <div class="card-body">--}}
        {{--                    <h5 class="card-title"><b>Name: </b>${resturants[i].details.name}</h5>--}}
        {{--                    <p class="card-text"><b>Address: </b>${resturants[i].details.formatted_address}</p>--}}
        {{--                    <p class="card-text"><b>Phone: </b>${resturants[i].details.formatted_phone_number}</p>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>`;--}}
        {{--        }--}}
        {{--        $('#card-body').html(cardBody);--}}
        {{--    }});--}}

    }

</script>
</body>
</html>
