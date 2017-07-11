
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">room</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Mission Map</h4>
                                    <div id="regularMap" class="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <h4 class="card-title">Group Current Members</h4>
                        <?php foreach ($members_data as $key => $member): ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">                            
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?= $member['username']; ?></p>
                                    <h3 class="card-title"><?= $member['full_name']; ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons text-danger">warning</i>
                                        <a href="<?= base_url(); ?>user/view/<?= $member['username']; ?>">Get User Info...</a>
                                    </div>
                                </div>
                            </div>
                        </div>                            
                        <?php endforeach; ?>



                                                                                                                                            
                    </div>

                </div>
            </div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6e_UtgMpRyWeFJwzzFc_UMM6feACY5AA"></script>

 <script type="text/javascript">

    $(document).ready(function() {

        var mapOptions = {
                //center: new google.maps.LatLng(9.9511,76.6306),
                zoom: 4,               
                scrollwheel: false //we disable de scroll over the map, it is a really annoing when you scroll through page
            }

        var map = new google.maps.Map(document.getElementById("regularMap"), mapOptions);

        displayMarkers();
       

        function displayMarkers(){
            
            var markersData = [
                <?php foreach ($members_data as $key => $member): ?>
                  {
                      lat: <?= $member['user_lat']; ?>,
                      lng: <?= $member['user_lng']; ?>,
                      name: "<?= $member['full_name']; ?>",
                      address1:"Rua Diogo Cão, 125",
                      address2: "Praia da Barra",
                      postalCode: "3830-772 Gafanha da Nazaré" // don’t insert comma in the last item of each marker
                   },   
                <?php endforeach; ?>                
                ];
           var bounds = new google.maps.LatLngBounds();

           for (var i = 0; i < markersData.length; i++){

              var latlng = new google.maps.LatLng(markersData[i].lat, markersData[i].lng);
              var name = markersData[i].name;
              var address1 = markersData[i].address1;
              var address2 = markersData[i].address2;
              var postalCode = markersData[i].postalCode;

              createMarker(latlng, name, address1, address2, postalCode);

              bounds.extend(latlng); 
           }

           map.fitBounds(bounds);
        }

        function createMarker(latlng, name, address1, address2, postalCode){
           var marker = new google.maps.Marker({
              map: map,
              position: latlng,
              title: name
           });
        }


    })
 </script>



</body>

