<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
    <style>
        #map {
            width: 100%;
            height: 600px;
        }
    </style>
</head>

<body>

<div class="container border border-warning rounded">
            <div class="alert alert-warning text-center" role="alert">
                <h1>WEBGIS</h1>
                <H2>Peta Kabupaten Sleman Daerah Istimewa Yogyakarta</H2>
            </div>

            <div class="card mt-4">
                <div class="card-header alert alert-warning">
                    <h4 id="kecamatan">Kecamatan Kabupaten Sleman</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-boedered">
                        <h4 id="kecamatan">Kecamatan</h4>
                        <tr class="text-center">
                            <th>Kecamatan</th>
                            <th>Longitude</th>
                            <th>Latitude</th>
                            <th>Luas</th>
                            <th>Jumlah Penduduk</th>
                        </tr>
                        <tr>
                            <td>Moyudan</td>
                            <td>110.2478</td>
                            <td>-7.7774</td>
                            <td>27.62</td>
                            <td>31497</td>
                        </tr>
                        <tr>
                            <td>Minggir</td>
                            <td>110.2484</td>
                            <td>-7.7318</td>
                            <td>27.27</td>
                            <td>29886</td>
                        </tr>
                        <tr>
                            <td>Seyegan</td>
                            <td>110.3003</td>
                            <td>-7.7265</td>
                            <td>26.63</td>
                            <td>47129</td>
                        </tr>
                        <tr>
                            <td>Godean</td>
                            <td>110.2957</td>
                            <td>-7.7681</td>
                            <td>26.84</td>
                            <td>72028</td>
                        </tr>
                        <tr>
                            <td>Gamping</td>
                            <td>110.3202</td>
                            <td>-7.7903</td>
                            <td>29.25</td>
                            <td>108675</td>
                    </table>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header alert alert-warning">
                    <h4 id="peta">Peta</h4>
                </div>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Inisialisasi peta
        var map = L.map("map").setView([-7.6881964, 110.3425598], 13);

        // Tile Layer Base Map
        var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution:
                            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            });

            var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            });

            var rupabumiindonesia = L.tileLayer('https://geoservices.big.go.id/rbi/rest/services/BASEMAP/Rupabumi_Indonesia/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Badan Informasi Geospasial'
            });

        // Menambahkan basemap ke dalam peta
        rupabumiindonesia.addTo(map);

        /*Marker
        var marker = L.marker([-6.1753924, 106.8271528]);


       // Menambahkan marker ke dalam peta
        marker.addTo(map);*/

    <?php
    // Create connection
    $conn = new mysqli("localhost", "root", "", "pgweb8");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM penduduk";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $longitude = $row['longitude'];
            $latitude = $row['latitude'];
            $info = $row['kecamatan'];
            echo "L.marker([$latitude,$longitude]).addTo(map).bindPopup('$info');";
        }
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>
    

    // Control Layer
    var baseMaps = {
                "OpenStreetMap": osm,
                "Esri World Imagery": Esri_WorldImagery,
                "Rupa Bumi Indonesia": rupabumiindonesia,
            };

            var overlayMaps = {
                "Marker": marker,
                "Circle": circle,
                "Polyline": polyline,
                "Polygon": polygon,
                "hilllshade":imageOverlay,
            };

            var controllayer = L.control.layers(baseMaps, overlayMaps, {collapsed: false,});
            controllayer.addTo(map);

            // Scale
            var scale = L.control.scale({
                position:"bottomright",
                imperial:false,
            });
            scale.addTo(map);

    </script>
</body>

</html>
