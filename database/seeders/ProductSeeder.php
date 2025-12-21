<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['Cải bó xôi baby organic', 45000, 'Thu hoạch sáng nay, giòn ngọt tự nhiên', 'cai-bo-xoi.jpg'],
            ['Cà chua beef Đà Lạt', 38000, 'Ngọt thanh như trái cây, ít hạt', 'ca-chua-beef.jpg'],
            ['Rau muống thủy canh', 22000, 'Không thuốc trừ sâu, xào tỏi tuyệt vời', 'rau-muong.jpg'],
            ['Bắp cải tím nhập khẩu', 55000, 'Giàu chất chống oxy hóa', 'bap-cai-tim.jpg'],
            ['Khoai lang mật', 28000, 'Ngọt tự nhiên, nướng/hấp đều ngon', 'khoai-lang-mat.jpg'],
            ['Bí đỏ hồ lô', 25000, 'Ngọt bùi, hấp chín ăn như kem', 'bi-do.jpg'],
            ['Cải kale organic', 85000, 'Siêu thực phẩm thế kỷ 21', 'cai-kale.jpg'],
            ['Xà lách Lolo tím', 65000, 'Salad cao cấp, không đắng', 'xa-lach-lolo.jpg'],
            ['Dưa leo baby', 35000, 'Giòn tan, không hạt', 'dua-leo-baby.jpg'],
            ['Cà rốt Đà Lạt', 32000, 'Ép nước đẹp da', 'ca-rot.jpg'],
        ];

        foreach ($products as $p) {
    Product::create([
        'name'        => $p[0],
        'price'       => $p[1],
        'description' => $p[2],
        'images'      => json_encode([$p[3]]), // hoặc ['cai-bo-xoi.jpg'] nếu dùng fillable cast
        // hoặc nếu chưa dùng cast: 'images' => '["cai-bo-xoi.jpg"]',
        'stock'       => 99,
        'category_id' => 1,
    ]);
}
    }
}