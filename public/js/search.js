$(document).ready(function () {
      $('#FindHouse').keyup(debounce(function(){
          // the text typed in the input field is assigned to a variable 
          var query = $(this).val();
          if(query.trim()!="")
          {
            $('#HouseResults').empty()
              $.ajax({
                  // assign a controller function to perform search action - route name is search
                  url:"/search/house",
                  // since we are getting data methos is assigned as GET
                  type:'POST',
                  //show the loader
                  beforeSend: function(){
                      // Show image container
                      $("#loader").show();
                     },
                  // data are sent the server
                  data:{'query':query},                             
                  success:function (data) { 
                      if(Object.keys(data).length==0){
                       alert('No houses with that criteria')
                      }else{
                          alert('Found '+Object.keys(data).length+' House(s)')                     
                         var htmlText = data.map(function(o){
                           return `
                               <div class="div-conatiner">
                               <h2 class="h3 font-weight-bold text-center">${o.house_name}</p>                          
                               <p class="p"> condition: ${o.condition}</p>
                               <p class="p"> Location: ${o.geo_location}</p>                           
                               <p class="p"> Status: ${o.status}</p>
                              <p class="p"> Rent: ${o.rent_amount}</p>
                              <a href="/house/profile/${o.id}">More Info</a>
                              </div>
                           `;
                         });

                         $('#HouseResults').append(htmlText);

                      }
                  },
                   statusCode: {
                       500: function() {
                        alert('Error')
                      },
                      419: function(){
                          alert('Not allowed')
                      }
                  },                              
                  complete:function(data){                                  
                      $("#loader").hide();
                     }
              })
          }else{
             $('#HouseResults').empty()
          }
          // call to an ajax function
         
          // end of ajax call
          },2000));

      
  });  

  function debounce(func, wait, immediate) {
      var timeout;
      return function() {
          var context = this, args = arguments;
          var later = function() {
              timeout = null;
              if (!immediate) func.apply(context, args);
          };
          var callNow = immediate && !timeout;
          clearTimeout(timeout);
          timeout = setTimeout(later, wait);
          if (callNow) func.apply(context, args);
      };
  };