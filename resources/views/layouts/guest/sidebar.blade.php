{{-- resources/views/layouts/guest/sidebar.blade.php --}}
<div class="left-sidebar">
    <h2>Danh mục</h2>
    <div class="panel-group category-products" id="accordian">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#tab-vegetable" data-toggle="tab">Rau củ</a>
                </h4>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#tab-fruit" data-toggle="tab">Trái cây</a>
                </h4>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#tab-dry" data-toggle="tab">Thực phẩm khô</a>
                </h4>
            </div>
        </div>

    </div>

    <div class="shipping text-center">
        <img src="{{ asset('frontend/images/home/shipping.jpg') }}" alt="Giao hàng nhanh" />
    </div>
</div>

<style>
    .left-sidebar .shipping {
    padding: 10px;
    text-align: center;
}

.left-sidebar .shipping img {
    width: 100%;
    height: auto;
    object-fit: contain;
    max-height: 520px;   /* tăng từ ~300px → 520px (lớn hơn ~50–70%) */
    display: block;
    margin: 0 auto;
}


</style>