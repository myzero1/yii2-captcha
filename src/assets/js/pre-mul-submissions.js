var count = 0;
$("form").on("beforeSubmit", function (event, messages) {
    if(count>0){
        return false;
    }else{
        count = count+1;
    }
    $(":submit").attr("disabled",true);
});