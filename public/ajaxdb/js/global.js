$(document).ready(function(){                                           //$-дальше идет JQuery; 1-ый аргумент - с кем делать;2-й - что делать
    $('.someClass').on('click',function(){                              // .-значит класс; #-значит айдишничек;
        var name = $(this).val();                                       // this-обращение у тому элементу,который главный в ЭТОЙ функции
        setTimeout(alert('hello'),5000);
        inputElement = $(this);

        if($.trim(name) !=''){
           $.post('ajaxdb/ajax/name.php',{name: name},function(data){
                //$('div#name-data').text(data);
               var obj = JSON.parse(data);
               //alert(data + " " + obj.status + " ->" + (data.status == 'ok') + obj);

               if(obj.status == 'ok')
               {
                   //alert(obj.status);
                   inputElement.closest('tr').remove();
               }else{
                   alert('ERROR');
               }

           });
        }
    });
});
