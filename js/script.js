$(document).ready(function(){

    $('#user_phone').mask("(999) 999-99-99");

    $(".uncorrect").hide();

    $('.btn_submit').click(function(){
      
        let tel = $('#user_phone').val();
        let email = $("input[name='email']").val();
        let adr_pattern = /[0-9a-z_-]+@[0-9a-z_-]+\.[a-z]{2,5}/i;

        if (tel == "") {
            $(".tel").show();
        }
        else {
            $(".tel").hide();
        }

        if (adr_pattern.test(email) == false) {
            $(".email").show();
        }
        else {
            $(".email").hide();
        }
       
        let fLet = $("input[name='name']").val()[0];
        let bfLet = fLet.toUpperCase();

        if (fLet != bfLet){
            $(".letter").show();
        }
        else
        {
            $(".letter").hide();
        }

    });

});