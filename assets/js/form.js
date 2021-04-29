// Удаление записи

$('document').ready(function() {
    $('.btn-delete').click(function(e) {
		
        userId = $(e.currentTarget).data('user-id');
        btn = this;
        
        
        $.ajax({
            type: 'POST',
            url: '../deleteUser',
            data: {'userId': userId},
            cache: false,
      
            success: function(result) {
                $('.btn-delete').closest('tr').last().remove(); // скрываем удаленный элемент
            }
        });
    });


    // Создание пользователя
    $('.delete-user').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: '../addUser',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
      
            success: function(result) {
                location.reload();
            }
        });
    });



});



