$(document).ready(function () {

    /* ===============================
       CAROUSEL + TAB FIX
    =============================== */
    if ($('#recommended-item-carousel').carousel) {
        $('#recommended-item-carousel').carousel({
            interval: 6000,
            pause: "hover"
        });
    }

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        $(window).trigger('resize');
    });


    /* ===============================
       TOAST SESSION (Laravel)
    =============================== */
    if (window.sessionSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: window.sessionSuccess,
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    if (window.sessionError) {
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: window.sessionError,
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }


    /* ===============================
       ADD TO CART (AJAX)
    =============================== */
    $('.add-to-cart-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');
        const token = form.find('input[name="_token"]').val();

        $.post(url, { _token: token }, function (data) {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Đã thêm vào giỏ hàng!',
                    timer: 1500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });

                $('#cart-count').text(data.cartCount);
            }
        });
    });


    /* ===============================
       CONFIRM DELETE CART ITEM
    =============================== */
    $('.delete-cart-item-form').on('submit', function (e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: 'Bạn có chắc muốn xóa sản phẩm này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, xóa!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });


    /* ===============================
       WISHLIST TOGGLE (AJAX)
    =============================== */
    $('.wishlist-btn').on('click', function (e) {
        e.preventDefault();

        const productId = this.dataset.productId;
        const heart = this.querySelector('.heart-icon');

        fetch(window.wishlistToggleUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(res => res.json())
        .then(data => {

            // Icon tim
            if (data.status === 'added') {
                heart.textContent = '❤️';
                heart.classList.add('heartbeat');
                setTimeout(() => heart.classList.remove('heartbeat'), 600);
            } else {
                heart.textContent = '🤍';
            }

            // Badge wishlist
            let badge = $('#wishlist-count');
            if (badge.length) {
                badge.text(data.count);
            } else if (data.count > 0) {
                $('#wishlist-link').append(
                    `<span id="wishlist-count" class="badge"
                        style="position:absolute;top:-8px;right:-8px;
                        background:#FE980F;font-size:10px;
                        padding:2px 6px;border-radius:50%;">
                        ${data.count}
                    </span>`
                );
            }

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: data.status === 'added' ? 'success' : 'info',
                title: data.status === 'added'
                    ? 'Đã thêm vào wishlist'
                    : 'Đã xóa khỏi wishlist',
                showConfirmButton: false,
                timer: 1500
            });
        })
        .catch(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Có lỗi xảy ra!',
                showConfirmButton: false,
                timer: 1500
            });
        });
    });

});
