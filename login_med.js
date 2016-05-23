$(document).ready(function(){
    $("main").on('click', "#sendCod", function(e) {
        $('#codice').prop('disabled',true);
        error = "";
        NProgress.start();
        var codice = $.trim($("#codice").val());
        var logType = "medici";
        var pass = "no";
        if (codice.length < 0 || codice == ""){
        error = "Inserisci il codice personale!";
    }
    if (error == "") {
            $.ajax({
            type: 'POST',
            url: 'login-redirect.php',
            data: '&codice='+ codice + '&logType='+ logType + '&pass='+ pass,
            dataType: 'json',
            cache: false,
            success: function(result) {
                if (result === "Login effettuato con successo!") {
                    NProgress.done();
                    window.location.replace("profilo-med.php");
                }else {
                    if (result === "notfinded") {
                        result = "I dati inseriti risultano essere sbagliati!";
                    }
                    if (result === "notexecuted") {
                        result = "Errore riscontrato con il database!";
                    }
                    if (result === "categorynotexists") {
                        result = "La categoria ricercata non esiste!";
                    }
                    if ($('#messageAlert').length) {
                            NProgress.done();
                            $('#codice').prop('disabled',false);
                        }else{
                        $("main").append('<div id="messageAlert">'+result+'</div>');
                        setTimeout('$("#messageAlert").remove()',2000); 
                        $('#codice').prop('disabled',false);
                        NProgress.done();
               }
                    
                }			
            },
            error: function(e, xhr){
                console.log(e + "-" + xhr)
                }
        });
    }else {
        if ($('#messageAlert').length) {
                NProgress.done();
                $('#codice').prop('disabled',false);
            }else{
            $("main").append('<div id="messageAlert">'+error+'</div>');
            setTimeout('$("#messageAlert").remove()',2000); 
            $('#codice').prop('disabled',false);
            NProgress.done();
    }
    } 	
    });
});
