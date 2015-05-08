$("document").ready(function(){
     $(".cp").keyup(function(){
         if($(this).val().length === 5){
             $.ajax({
                 type: 'get',
                 url: Routing.generate('villes',{cp:  $(this).val()}),
                 //url: 'http://localhost/Nadoeco/web/app_dev.php/utilisateurs/villes/'+$(this).val(),
                 beforeSend: function()
                              {
                                 if ($('.loading').length == 0)
                                    $('form .ville').parent().append('<div class="loading"></div>');
                                  $('.ville option').remove();
                                console.log('Ca charge...');
                              },
                 success: function(data){
                             $.each(data.villes,function(index,value){
                                 $('.ville').append($('<option>',{value: value,text:value}));
                                 //console.log('élement récuperé avec succé'+value);

                             });

                                $('.loading').remove();
                                console.log('élement récuperé avec succé'+data.ville);
                           }

             });
         }else{
             $('.ville').val('');
             console.log('Veuiller saisir 5 chiffres');
         }
     });
});