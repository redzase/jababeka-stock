$('.datepicker').datepicker({
    autoclose: true
  })

  $(function () {
      if (parseFloat($('#us2-lat').val())){
        var lat = parseFloat($('#us2-lat').val());
      }else{
        var lat = 106.84559899999999;
      }

      if (parseFloat($('#us2-lon').val())){
        var lng = parseFloat($('#us2-lon').val());
      }else{
        var lng = -6.2087634;
      }

    
       var latlng = new google.maps.LatLng(lat, lng),
           image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';
       var mapOptions = {
           center: new google.maps.LatLng(lat, lng),
           zoom: 13,
           mapTypeId: google.maps.MapTypeId.ROADMAP,
           panControl: true,
           panControlOptions: {
               position: google.maps.ControlPosition.TOP_RIGHT
           },
           zoomControl: true,
           zoomControlOptions: {
               style: google.maps.ZoomControlStyle.LARGE,
               position: google.maps.ControlPosition.TOP_left
           }
       },
       map = new google.maps.Map(document.getElementById('us2'), mapOptions),
           marker = new google.maps.Marker({
               position: latlng,
               map: map,
               icon: image
           });
       var input = document.getElementById('us2-address');

       var autocomplete = new google.maps.places.Autocomplete(input, {
           types: ["geocode"]
       });

       autocomplete.bindTo('bounds', map);
       var infowindow = new google.maps.InfoWindow();
       google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
           infowindow.close();
           var place = autocomplete.getPlace();
           if (place.geometry.viewport) {
               map.fitBounds(place.geometry.viewport);
           } else {
               map.setCenter(place.geometry.location);
               map.setZoom(17);
           }
           moveMarker(place.name, place.geometry.location);
           $('#us2-lat').val(place.geometry.location.lat());
           $('#us2-lon').val(place.geometry.location.lng());
       });


       var get_maps = google.maps.event.addListener(map, 'click', function (event) {
           $('#us2-lat').val(event.latLng.lat());
           $('#us2-lon').val(event.latLng.lng());
           infowindow.close();
                   var geocoder = new google.maps.Geocoder();
                   geocoder.geocode({
                       "latLng":event.latLng
                   }, function (results, status) {
                       if (status == google.maps.GeocoderStatus.OK) {
                           var lat = results[0].geometry.location.lat(),
                               lng = results[0].geometry.location.lng(),
                               placeName = results[0].address_components[0].long_name,
                               latlng = new google.maps.LatLng(lat, lng);
                           moveMarker(placeName, latlng);
                           $("#us2-address").val(results[0].formatted_address);
                       }
                   });
       });

       $( "#us2-address" ).on( "keydown", function( event ) {
           if (event.which=='13'){
                  get_maps;
                  return false;
           }
       });


      
       function moveMarker(placeName, latlng) {
           marker.setIcon(image);
           marker.setPosition(latlng);
           infowindow.setContent(placeName);
       }


        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            "latLng":latlng
        }, function (results, status) {
            
            if (status == google.maps.GeocoderStatus.OK) {
                var lat = results[0].geometry.location.lat(),
                    lng = results[0].geometry.location.lng(),
                    placeName = results[0].address_components[0].long_name,
                    latlng = new google.maps.LatLng(lat, lng);
                moveMarker(placeName, latlng);
                
                $("#us2-address").val(results[0].formatted_address);
            }
        });

        
        



   });




  function addFields(id, name, type ,footnotes=false, name_file="nama_file", show_thumbnail=true) {
      original_id = id
      str_id = "'" + (id) + "'"
      var id = '#' + id;
      var id_rm = $(id+" > div").length;
      var base_url = $("#body").data("baseurl");
      if (footnotes == true){
          var footnotes_name = 'footnotes'+name+id_rm;
          var pricelist_add = '<div style="margin-top:10px;" class="input-group area col-sm-10" id="'+name+id_rm+'">'+
                          '<input type="'+type+'" onchange="readURL(this,\''+name+id_rm+'\');" class="form-control" name="'+name_file+'">'+
                          '<span class="bg-red input-group-addon" style="margin-right:0px;cursor:pointer;" onclick="removeFieldFootnotes(\''+name+id_rm+'\',\''+footnotes_name+'\',\''+name+id_rm+'\')">remove</span>'+
                          '</div>';
      
          pricelist_add +='<input type="text" id="'+footnotes_name+'" class="form-control pull-right col-sm-6" style="margin-right: 117px;width: 800px;margin-top: 10px;margin-bottom:10px;" placeholder="footnotes" name="footnotes[]">'; 

          if (show_thumbnail) {
            pricelist_add +=  '<div class="col-sm-9" id="div_prev'+(name+id_rm)+'" style="border: 1px black;">'+
                              '<img id="prev_image'+(name+id_rm)+'" style="width:100px;height:80px;" src="#" onerror="this.src=\''+ base_url +'static/images/no-image.png\';" alt="your image"/>'+
                              '</div>';
          }
        }else{
          var pricelist_add = '<div style="margin-top:10px;" class="input-group area col-sm-10" id="'+name+id_rm+'">'+
                          '<input type="'+type+'" class="form-control" onchange="readURL(this,\''+name+id_rm+'\');"  name="'+name_file+'">'+
                          '<span class="bg-red input-group-addon" style="margin-right:0px;cursor:pointer;" onclick="removeField(\''+name+id_rm+'\',\''+name+id_rm+'\')">remove</span>'+
                          '</div>';

            if (show_thumbnail) {
              pricelist_add +=  '<div class="col-sm-9" id="div_prev'+name+id_rm+'" style="border: 1px black;">'+
              '<img id="prev_image'+name+id_rm+'" style="width:100px;height:80px;" src="" onerror="this.src=\''+ base_url +'static/images/no-image.png\';" alt="your image"/>'+
              '</div>';
            }
      }
      $(id).append(pricelist_add);
  }    

  function removeField(id,image_id){
      $('#' + id).parent().find("#hd_img_delete").val("1");
      $('#' + id).next().remove();
      $('#' + id).remove();
      $('#div_prev' + image_id).remove();
  }
  function removeFieldFootnotes(id,footnotesid,image_id){
      $('#' + id).parent().find("#hd_img_delete").val("1");
      $('#' + id).remove();
      $('#' + footnotesid).remove();
      $('#div_prev' + image_id).remove();
  }

  function showimage(id){
      // Get the modal
      var modal = document.getElementById('myModal');

      // Get the image and insert it inside the modal - use its "alt" text as a caption
      var img = document.getElementById(id);
      var modalImg = document.getElementById("img01");
    //   var captionText = document.getElementById("caption");
      img.onclick = function(){
          
          modal.style.display = "block";
          modalImg.src = this.getAttribute("data_src");
        //   captionText.innerHTML = this.alt;
      }

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];

      // When the user clicks on <span> (x), close the modal
      span.onclick = function() { 
          modal.style.display = "none";
      }

  }    


  function get_map(lat,long){
      image ='<div class="item active">'
              +'<iframe width="900px" height="600px" frameborder="0" scrolling="no"  marginheight="0" marginwidth="0" '
              +'src="https://maps.google.com/maps?q='+lat+','+long+'&hl=es;z=14&amp;output=embed">'
              +'</iframe>'
              +'</div>';

      $('.carousel-inner').html(image);

  }

  function get_data(id,url,title,type,tbl){
    $('.carousel-indicators').html();
    $('.carousel-inner').html();
      
    if (tbl=='product_assets'){
        var collumn = 'product_id';
    } else if(tbl=='product_update_assets'){
        var collumn = 'product_update_id';
    }else if(tbl=='tenant_assets'){
        var collumn =  'tenant_id';
    }else if(tbl=='leasing_assets'){
        var collumn =  'leasing_id';
    }else if(tbl=='event_assets'){
        var collumn =  'event_id';
    }else if(tbl=='promotion_assets'){
        var collumn =  'promotion_id';
    }else if(tbl=='timeline_assets'){
        var collumn =  'timeline_id';
    }else if(tbl=='service_assets'){
        var collumn =  'service_id';
    }

    $.ajax({
      type: "POST",
      url: url,
      data: {'id':id,'collumn':collumn, 'type':type,'tbl':tbl,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
    }).done(function(response) {
      $('.modal-title').html(title);
      console.log(response.data.length);
      if(response.status == true){
        var length = response.data.length;
      }else{
        var length = 0;
        $('.left').empty();
        $('.right').empty();
      }
        var body = "";
        var active = "";
        var image_indikator ="";
        var image = "";
        var content = "";
        var base_url = $("#body").data("baseurl");
       
        for (i = 0; i < length; i++) { 
            if (type==4){
                var str = response.data[i].assets;
                var link = str.replace('https://www.youtube.com/watch?v=','https://www.youtube.com/embed/');
                content = '<iframe width="854" height="510" src="'+link+'" frameborder="0" allowfullscreen></iframe>';  
            
            }else{
                content = '<img style="height:600px;widht:400px" onerror="this.src=\''+ base_url +'static/images/no-image.png\';" src="'+ base_url + response.data[i].assets+'" alt="price-list-'+i+'">';

            }

            if (i == 0){
              image +='<div class="item active">'
                      + content
                      +'</div>';

              image_indikator +='<li data-target="#myCarousel" data-slide-to="'+i+'" class="active"></li>'
              
            }else{
              
              image +='<div class="item">'
                    + content
                    +'</div>';
              image_indikator +='<li data-target="#myCarousel" data-slide-to="'+i+'"></li>'

            }
      
        }

        $('.carousel-indicators').html(image_indikator);
        $('.carousel-inner').html(image);
      

    });

    
  } 

  function delete_confirm(url){

    var txt;
    var r = confirm("Are You Sure!");
    if (r == true) {
        document.location.href=url;
    } else {
        return false;
    }

  }


  function readURL(input,id=0) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#div_prev'+id).show();
        $('#prev_image'+id).attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#img_input").change(function() {
    readURL(this);
  });


  
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };

    function isAlphaNumeric(value) {
        return /^\w+$/i.test(value);
    }
