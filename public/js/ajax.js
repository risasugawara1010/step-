$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
});

    // 検索機能
    $('#searchBtn').on('click', function(e) {
        e.preventDefault();
        let formData = $('#searchForm').serialize(); // クエリパラメータ形式に変換
    
        $.ajax({
            url: "search",
            type: 'GET',
            data: formData,
            dataType: 'json',
            /*headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },*/
                success: function(data) {
                    const tableBody = $('.table tbody');
                    tableBody.empty();
                
                    
                    if (data && data.data && Array.isArray(data.data)) {
                        $.each(data.data, function(index, product) {
                        let imgSrc = product.img_path ? `storage/images/${product.img_path}` : ''; // 画像がある場合はそのパスを設定、ない場合は空文字列を設定
                        let row = `
                            <tr id="productId-${product.id}" class="productId">
                                <td>${product.id}</td>
                                <td>${product.product_name}</td>
                                <td>￥${product.price}</td>
                                <td>${product.stock}</td>
                                <td><img src="${imgSrc}" alt="${product.name}" width="100" style="display: ${imgSrc ? 'block' : 'none'}"></td> <!-- 画像がある場合は表示、それ以外は非表示 -->
                                <td>${product.comment}</td>
                                <td>${product.company.company_name}</td>
                                <td>
                                    <form id="deleteForm-${product.id}" action="products/${product.id}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="button" class="btn btn-danger delete-btn" data-id="${product.id}">削除</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="products/${product.id}" class="btn btn-info ml-2">詳細</a>
                                </td>
                            </tr>`;
                        tableBody.append(row);
                    });
                    // ページネーションリンクを更新
                    $('.pagination').html(data.links);
                    // ソート機能を再適用
                    $("#productTable").trigger("update");
                } else {
                    console.error('Unexpected response format:', data);
                }
                
    
                },
            error: function() {
                alert('Search failed.');
            }
        });
    });

//　削除機能
$(document).on('click', '.delete-btn', function() {
    const productId = $(this).data('id');
    const $row = $(this).closest('tr');
    
    if (confirm('本当に削除しますか？')) {
        $.ajax({
            url: `/products/delete/${productId}`,
            method: 'POST',
            data: { _method: 'DELETE' },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $row.remove();
                } else {
                    alert('削除に失敗しました。' + (response.message || ''));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                alert('削除処理中にエラーが発生しました。' + (xhr.responseJSON?.message || ''));
            }
        });
    }
});

