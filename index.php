<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>UpInside Play: Google Maps API</title>

        <style>
            body{
                padding: 30px 20%;
            }

            #map {
                position: relative;
                padding-bottom: 56.25%;
                height: 0;
                overflow: hidden;
                max-width: 100%;
                background-color: grey;
            }

            .locations{
                display: block;
                margin-top: 20px;
            }

            .locations_item{
                display: inline-block;
                font-size: 0.875em;
                cursor: pointer;
                padding: 10px;
                margin: 10px;
                border: 1px solid #ccc;
            }
        </style>
    </head>
    <body>
        <div id="map"></div>
        <div class="locations">
            <?php
            require '../Source/Models/GoogleMaps.php';
            $maps = new Source\Models\GoogleMaps;

            $fpolis = clone $maps;
            $fpolis->setAddress("Florianópolis");
            echo "<span class='locations_item' data-location='{$fpolis->getAddress()}|{$fpolis->getLatLng()->lat}|{$fpolis->getLatLng()->lng}'>{$fpolis->getAddress()}</span>";

            $morro = clone $maps;
            $morro->setAddress("Morro das Pedras, Florianópolis");
            echo "<span class='locations_item' data-location='{$morro->getAddress()}|{$morro->getLatLng()->lat}|{$morro->getLatLng()->lng}'>{$morro->getAddress()}</span>";

            $lagoa = clone $maps;
            $lagoa->setAddress("Lagoa da Conceição, Florianópolis");
            echo "<span class='locations_item' data-location='{$lagoa->getAddress()}|{$lagoa->getLatLng()->lat}|{$lagoa->getLatLng()->lng}'>{$lagoa->getAddress()}</span>";

            $campeche = clone $maps;
            $campeche->setAddress("Campeche, Florianópolis");
            echo "<span class='locations_item' data-location='{$campeche->getAddress()}|{$campeche->getLatLng()->lat}|{$campeche->getLatLng()->lng}'>{$campeche->getAddress()}</span>";

            $canas = clone $maps;
            $canas->setAddress("Canasvieiras, Florianópolis");
            echo "<span class='locations_item' data-location='{$canas->getAddress()}|{$canas->getLatLng()->lat}|{$canas->getLatLng()->lng}'>{$canas->getAddress()}</span>";

            echo "<span class='locations_item' data-location='"
            . "{$fpolis->getAddress()}|{$fpolis->getLatLng()->lat}|{$fpolis->getLatLng()->lng} ||"
            . "{$morro->getAddress()}|{$morro->getLatLng()->lat}|{$morro->getLatLng()->lng} ||"
            . "{$lagoa->getAddress()}|{$lagoa->getLatLng()->lat}|{$lagoa->getLatLng()->lng} ||"
            . "{$campeche->getAddress()}|{$campeche->getLatLng()->lat}|{$campeche->getLatLng()->lng} ||"
            . "{$canas->getAddress()}|{$canas->getLatLng()->lat}|{$morro->getLatLng()->lng}"
            . "'>Todos em Floripa</span>";
            ?>
        </div>

        <script src="jquery-3.2.1.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=SUA_KEY_AQUI"></script>
        <script>
            $(function () {
                //localizações
                var locations = [
                    {
                        title: "Rua Huberto Rohden, 100<br>Fpolis/SC",
                        lat: -27.6720101,
                        lng: -48.5054769,
                        icon: 'images/loc.png'
                    },
                    {
                        title: "Avenida Pequeno Príncipe, 800<br>Fpolis/SC",
                        lat: -27.6763079,
                        lng: -48.5005945,
                        icon: 'images/loc.png'
                    },
                    {
                        title: "Avenida Campeche, 2600<br>Fpolis/SC",
                        lat: -27.6657834,
                        lng: -48.4809122,
                        icon: 'images/loc.png'
                    }
                ];

                function getMap(locations) {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 1,
                        center: locations[0]
                    });

                    //map center
                    var bounds = new google.maps.LatLngBounds();

                    //cria marcas
                    locations.map(function (location) {
                        var marker = new google.maps.Marker({
                            animation: google.maps.Animation.DROP,
                            position: location,
                            icon: location.icon,
                            map: map
                        });

                        locationInfo(marker, location.title);
                        bounds.extend(marker.position);
                    });

                    map.fitBounds(bounds);
                    var zoom = map.getZoom();
                    map.setZoom(zoom > 15 ? 15 : zoom);
                }
                getMap(locations);

                function locationInfo(marker, content) {
                    var info = new google.maps.InfoWindow({
                        content: content
                    });

                    marker.addListener("click", function () {
                        info.open(marker.get('map'), marker);
                    });
                }

                $(".locations_item").click(function () {
                    var location = $(this).attr("data-location");
                    if (location.indexOf("||") >= 1) {
                        var setGroup = location.split("||");
                        var groupLocation = [];

                        setGroup.map(function (getLoc) {
                            var setLoc = getLoc.split("|");
                            groupLocation.push({
                                title: setLoc[0],
                                lat: parseFloat(setLoc[1]),
                                lng: parseFloat(setLoc[2]),
                                icon: "images/loc.png"
                            });
                        });
                        getMap(groupLocation);
                    } else {
                        var setLoc = location.split("|");
                        var newLoc = [
                            {
                                title: setLoc[0],
                                lat: parseFloat(setLoc[1]),
                                lng: parseFloat(setLoc[2]),
                                icon: "images/loc.png"
                            }
                        ];
                        getMap(newLoc);
                    }
                });
            });
        </script>
    </body>
</html>
