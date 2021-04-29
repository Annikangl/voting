$('document').ready(function() {

    $('.btn-nav').click(function(e) {
        e.stopPropagation();
        var $this = $(this);
        if(!$this.hasClass('active')){
            $this.addClass("active");
        }
    });
});