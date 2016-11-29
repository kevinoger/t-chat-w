$(document).ready(function(){
    $('button.close').click(function(e) {
        e.preventDefault();
        var dataDismiss = $(this).data('dismiss');
        
        $(this).closest('.'+dataDismiss).remove();
    });
});