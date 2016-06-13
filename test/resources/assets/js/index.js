$('document').ready(
    function(){

$('#myform').on('submit',
    function(e){
        e.preventDefault();
        $('#secondform').remove();
        $('#forms').empty();
        $('#error').empty();
 var input=$('#searchBar').val();
       console.log($('#searchBar').val());
      var token=$('input[name=_token]').val();
        console.log($('meta[name=csrf_token]').attr('content'));
        console.log(token);
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf_token]').attr('content') }
        });
        $.ajax({
            method:'POST',
            url:"getlines",
            data:{user_input:input,_token:token}
        }).done(function(data){
            console.log(data);
            if(data.error != null){ $('#second').append('<p id="error">'+data.error+'</p>');
            }else{
            var html="<form method='post' action='#' id='secondform'>" +
                "  <div class='form-group'><select id='lines' class='form-control'></select></div>" +
                "<div class='form-group'><select id='languages' class='form-control'>" +
                "<option value='En'>English</option><option value='Fr'>French</option></select></div>" +
                "<button type='submit' class='btn btn-info'>Get Forms</button></form>";
            $('#second').append(html);
            $.each(data,function(index,value){
                $('#lines').append('<option value="'+value.id+'">'+value.line_name+'</option>');
            });
          $('#secondform').submit(function(e){
              e.preventDefault();
$('#forms').empty();
              var line=$('#lines').val();
              var lang=$('#languages').val();

              $.post('getforms',{_token:$('input[name=_token]').val(),line:line,lang:lang,input:input},function(data){
                  console.log(data.form);
                  if(data.relation=='and'||data.relation=='single') {
                      $.each(data.form, function (index, value) {

                          console.log(value);
                          $('#forms').append('<p><a href="/apps/'+value+'">/apps/' + value + '</a></p>');

                      });
                  }else if(data.relation=='or'){
                      $('#forms').append('<form action="#" method="post" id="choosefile">' +
                          '  <div class="form-group"><select id="choose"></select></div><button class="btn btn-info" type="submit">Choose Form</button></form>');
                      $('#choose').append('<option>Select forms</option>');
                      $.each(data.form, function (index, value) {

                          console.log(value);
                          $('#choose').append('<option value="'+value+'">' + value + '</option>');

                      });

                      $('#choosefile').submit(function(e){
                          e.preventDefault();
                          $('#file').remove();
                          console.log($('#choose').val());
                          var file=$('#choose').val();
                          $('#forms').append('<a id="file" href="/apps/'+file+'">/apps/' + file + '</a>');
                      });
                  }
              });
          });
        }});
    }
);
    }
)