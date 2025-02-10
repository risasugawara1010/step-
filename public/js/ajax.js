$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
});

$(document).on('submit', '#search-form', function(e) {
    e.preventDefault();

    const formData = $(this).serialize();

    console.log('FormData:', formData);

    $.ajax({
        url: 'products',
        type: 'GET',
        data: formData,
        success: function(response) {
            $('#product-list').html($(response).find('#product-list').html());
        },
        error: function() {
            console.error('Error occurred during search.');
            alert('検索中にエラーが発生しました。');
        }
    });
});

// 検索ボタンクリック時のイベントハンドラー
$(document).on('click', '#search-button', function(e) {
    e.preventDefault();
    $('#search-form').submit();
});


$(document).on('submit', '.delete-form', function(e) {
    e.preventDefault(); 

    if (!confirm('本当に削除しますか？')) return; 

    let form = $(this); 
    let url = form.attr('action'); 

    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            alert(response.message); 
            form.closest('tr').remove(); 
        },
        error: function(xhr) {
            alert('削除に失敗しました: ' + xhr.responseJSON.message); 
        }
    });
});