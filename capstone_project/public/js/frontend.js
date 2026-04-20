/* =============================================
   ShoeStore Frontend JavaScript
   AJAX Cart, Wishlist, Live Search, Filters
   ============================================= */

$(document).ready(function () {

    /* ================================================
       LIVE SEARCH (AJAX)
       ================================================ */
    let searchTimer;

    $('#liveSearch').on('input', function () {
        clearTimeout(searchTimer);
        const q = $(this).val().trim();

        if (q.length < 2) {
            $('#searchResults').addClass('d-none').empty();
            return;
        }

        searchTimer = setTimeout(function () {
            $.get('/search', { q: q }, function (products) {
                const $results = $('#searchResults');
                $results.empty();

                if (products.length === 0) {
                    $results.html('<div class="p-3 text-muted text-center small">No products found.</div>');
                } else {
                    $.each(products, function (i, p) {
                        $results.append(`
                          <a href="/product/${p.slug}" class="search-result-item">
                            <img src="${p.image}" alt="${p.name}">
                            <div>
                              <div class="fw-600 small">${p.name}</div>
                              <div class="text-primary fw-700 small">₹${p.price}</div>
                            </div>
                          </a>`);
                    });
                }
                $results.removeClass('d-none');
            });
        }, 350);
    });

    // Close search results on outside click
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.search-wrapper').length) {
            $('#searchResults').addClass('d-none');
        }
    });

    /* ================================================
       ADD TO CART (AJAX)
       ================================================ */
    $(document).on('click', '.btn-add-cart', function (e) {
        e.preventDefault();

        const btn       = $(this);
        const productId = btn.data('product-id');
        const size      = $('[name="size"]:checked, .size-btn.active').first().val() ||
                          $('[name="size"]:checked, .size-btn.active').first().data('size') || '';
        const color     = $('.color-btn.active').data('color') || '';
        const qty       = parseInt($('#qtyInput').val() || 1);

        const origText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Adding...').prop('disabled', true);

        $.ajax({
            url:  '/cart/add',
            type: 'POST',
            data: { product_id: productId, quantity: qty, size: size, color: color },
            success: function (res) {
                if (res.success) {
                    showToast(res.message, 'success');
                    updateCartBadge(res.cart_count);
                    // Animate cart icon
                    $('#cartBadge').addClass('animate__animated animate__bounceIn');
                    setTimeout(() => $('#cartBadge').removeClass('animate__animated animate__bounceIn'), 600);
                } else {
                    showToast(res.message, 'danger');
                }
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || 'Something went wrong.';
                showToast(msg, 'danger');
            },
            complete: function () {
                btn.html(origText).prop('disabled', false);
            }
        });
    });

    /* ================================================
       CART QTY UPDATE (AJAX)
       ================================================ */
    $(document).on('click', '.qty-btn', function () {
        const action = $(this).data('action'); // 'inc' or 'dec'
        const itemId = $(this).data('item-id');
        const $input = $(`.qty-input[data-item-id="${itemId}"]`);
        let qty      = parseInt($input.val());

        if (action === 'inc') {
            qty++;
        } else if (action === 'dec' && qty > 1) {
            qty--;
        } else {
            return;
        }
        $input.val(qty);
        updateCartItem(itemId, qty);
    });

    $(document).on('change', '.qty-input', function () {
        const itemId = $(this).data('item-id');
        const qty    = parseInt($(this).val());
        if (qty < 1) { $(this).val(1); return; }
        updateCartItem(itemId, qty);
    });

    function updateCartItem(itemId, qty) {
        $.ajax({
            url:  `/cart/update/${itemId}`,
            type: 'PATCH',
            data: { quantity: qty },
            success: function (res) {
                if (res.success) {
                    $(`#subtotal-${itemId}`).text('₹' + res.subtotal);
                    $('#cartTotal').text('₹' + res.cart_total);
                    updateCartBadge(res.cart_count);
                } else {
                    showToast(res.message, 'danger');
                }
            },
            error: function (xhr) {
                showToast(xhr.responseJSON?.message || 'Update failed.', 'danger');
            }
        });
    }

    /* ================================================
       REMOVE CART ITEM (AJAX)
       ================================================ */
    $(document).on('click', '.btn-remove-item', function (e) {
        e.preventDefault();
        const itemId = $(this).data('item-id');
        const $row   = $(`#cart-item-${itemId}`);

        $.ajax({
            url:  `/cart/remove/${itemId}`,
            type: 'DELETE',
            success: function (res) {
                if (res.success) {
                    $row.fadeOut(350, function () { 
                        $(this).remove();
                        if (res.cart_count === 0) {
                            location.reload(); // Show empty cart message
                        }
                    });
                    $('#cartTotal').text('₹' + res.cart_total);
                    updateCartBadge(res.cart_count);
                    showToast(res.message, 'success');
                }
            }
        });
    });

    /* ================================================
       WISHLIST TOGGLE (AJAX)
       ================================================ */
    $(document).on('click', '.btn-wishlist', function (e) {
        e.preventDefault();
        const btn       = $(this);
        const productId = btn.data('product-id');

        $.ajax({
            url:  '/wishlist/toggle',
            type: 'POST',
            data: { product_id: productId },
            success: function (res) {
                if (res.success) {
                    if (res.status) {
                        btn.html('<i class="bi bi-heart-fill"></i>').addClass('active');
                    } else {
                        btn.html('<i class="bi bi-heart"></i>').removeClass('active');
                    }
                    showToast(res.message, res.status ? 'success' : 'secondary');
                }
            },
            error: function () {
                window.location.href = '/login';
            }
        });
    });

    /* ================================================
       SIZE & COLOR SELECTION (Product Detail)
       ================================================ */
    $(document).on('click', '.size-btn', function () {
        $('.size-btn').removeClass('active');
        $(this).addClass('active');
        $('[name="size"]').val($(this).data('size'));
    });

    $(document).on('click', '.color-btn', function () {
        $('.color-btn').removeClass('active');
        $(this).addClass('active');
        $('[name="color"]').val($(this).data('color'));
    });

    /* ================================================
       PRODUCT IMAGE GALLERY (Product Detail)
       ================================================ */
    $(document).on('click', '.thumbnail-img', function () {
        const src = $(this).data('src');
        $('#mainProductImage').attr('src', src);
        $('.thumbnail-img').removeClass('active');
        $(this).addClass('active');
    });

    /* ================================================
       QTY SPINNER (Product Detail)
       ================================================ */
    $(document).on('click', '#qtyDecrease', function () {
        const $input = $('#qtyInput');
        if (parseInt($input.val()) > 1) $input.val(parseInt($input.val()) - 1);
    });

    $(document).on('click', '#qtyIncrease', function () {
        $('#qtyInput').val(parseInt($('#qtyInput').val()) + 1);
    });

    /* ================================================
       COUPON APPLY (Checkout — AJAX)
       ================================================ */
    $('#applyCouponBtn').on('click', function () {
        const code = $('#couponCode').val().trim();
        if (!code) return;

        $(this).html('<span class="spinner-border spinner-border-sm"></span>').prop('disabled', true);

        $.ajax({
            url:  '/checkout/apply-coupon',
            type: 'POST',
            data: { code: code },
            success: function (res) {
                if (res.success) {
                    $('#couponMessage').html(`<div class="alert alert-success py-2 small">${res.message}</div>`);
                    $('#discountRow').show();
                    $('#discountAmount').text('- ₹' + res.discount);
                    $('#grandTotal').text('₹' + res.total);
                } else {
                    $('#couponMessage').html(`<div class="alert alert-danger py-2 small">${res.message}</div>`);
                }
            },
            complete: function () {
                $('#applyCouponBtn').html('Apply').prop('disabled', false);
            }
        });
    });

    /* ================================================
       PRICE RANGE FILTER
       ================================================ */
    $('#priceRange').on('input', function () {
        $('#priceValue').text('₹' + $(this).val());
    });

    /* ================================================
       NAVBAR SCROLL EFFECT
       ================================================ */
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 50) {
            $('#mainNavbar').addClass('scrolled');
        } else {
            $('#mainNavbar').removeClass('scrolled');
        }
    });

    /* ================================================
       HELPERS
       ================================================ */
    function updateCartBadge(count) {
        const $badge = $('#cartBadge');
        $badge.text(count);
        if (count > 0) {
            $badge.removeClass('d-none');
        } else {
            $badge.addClass('d-none');
        }
    }

    function showToast(message, type = 'success') {
        const toast    = document.getElementById('liveToast');
        const toastMsg = document.getElementById('toastMessage');
        if (!toast || !toastMsg) return;
        toastMsg.textContent = message;
        toast.className = `toast align-items-center border-0 shadow-lg text-white bg-${type}`;
        new bootstrap.Toast(toast, { delay: 3000 }).show();
    }

    /* ================================================
       FADE-IN ANIMATION ON SCROLL (Intersection Observer)
       ================================================ */
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                $(entry.target).addClass('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    $('.product-card, .category-card, .stat-card').each(function () {
        observer.observe(this);
    });
});
