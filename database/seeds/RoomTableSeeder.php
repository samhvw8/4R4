<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        srand(time());
        $faker = Faker::create();
        $faker->seed(time());

        $streets_dong_da = ['An Trach', 'Bich Cau', 'Cat Linh', 'Cau Giay', 'Cau Moi', 'Cho Kham Thien', 'Chua Boc', 'Chua Lang', 'Dang Tien Dong', 'Dang Tran Con', 'Dang Van Ngu', 'Dao Duy Anh', 'Doan Thi Diem', 'Dong Cac', 'Dong Tac', 'Giai Phong', 'Giang Vo', 'Hang Chao', 'Hao Nam', 'Ho Dac Di', 'Ho Giam', 'Hoang Cau', 'Hoang Ngoc Phach', 'Hoang Tich Tri', 'Huynh Thuc Khang', 'Kham Thien', 'Khuong Thuong', 'Kim Hoa', 'La Thanh', 'Lang', 'Lang Ha', 'Le Duan', 'Luong Dinh Cua', 'Ly Van Phuc', 'Mai Anh Tuan', 'Nam Dong', 'Ngo Si Lien', 'Ngo Tat To', 'Nguyen Chi Thanh', 'Nguyen Hong', 'Nguyen Khuyen', 'Nguyen Luong Bang', 'Nguyen Nhu Do', 'Nguyen Phuc Lai', 'Nguyen Thai Hoc', 'Nguyen Trai', 'O Cho Dua', 'Pham Ngoc Thach', 'Phan Phu Tien', 'Phan Van Tri', 'Phao Dai Lang', 'Phuong Mai', 'Quoc Tu Giam', 'Tay Son', 'Thai Ha', 'Thai Thinh', 'Ton Duc Thang', 'Ton That Tung', 'Tran Huu Tuoc', 'Tran Quang Dieu', 'Tran Quy Cap', 'Trinh Hoai Duc', 'Truc Khe', 'Trung Liet', 'Truong Chinh', 'Van Mieu', 'Vinh Ho', 'Vo Van Dung', 'Vong', 'Vu Ngoc Phan', 'Vu Thanh', 'Xa Dan', 'Y Mieu', 'Yen Lang'];
        $wards_dong_da = ['Cat Linh', 'Hang Bot', 'Kham Thien', 'Khuong Thuong', 'Kim Lien', 'Lang Ha', 'Lang Thuong', 'Nam Dong', 'Nga Tu So', 'O Cho Dua', 'Phuong Lien', 'Phuong Mai', 'Quang Trung', 'Quoc Tu Giam', 'Thinh [Quang', 'Tho Quan', 'Trung Liet', 'Trung Phung', 'Trung Tu', 'Van Chuong', 'Van Mieu'];
        foreach (range(1, 10) as $index) {
            try {
                DB::table('rooms')->insert([
                    'user_id' => rand(1, 100),
                    'price' => rand(100000, 10000000),
                    'area' => rand(10 * 10, 100 * 10) / 10,
                    'description' => $faker->text(150),
                    'image_album_url' => $faker->imageUrl(),
                    'street' => rand(1, 100) . ' ' . $streets_dong_da[array_rand($streets_dong_da)],
                    'district' => 'Dong Da',
                    'ward' => $wards_dong_da[array_rand($wards_dong_da)],
                    'city' => 'Hanoi',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()

                ]);
            } catch (Illuminate\Database\QueryException $e) {

            } catch (PDOException $ee) {

            }

        }

        $streets_ba_dinh = ['An Xa', 'Ba Huyen Thanh Quan', 'Bac Son', 'Buoi', 'Cao Ba Quat', 'Cau Giay', 'Chau Long', 'Chu Van An', 'Chua Mot Cot', 'Cua Bac', 'Dang Dung', 'Dang Tat', 'Dao Tan', 'Dien Bien Phu', 'Doc Lap', 'Doc Ngu', 'Doi Can', 'Doi Nhan', 'Giang Van Minh', 'Giang Vo', 'Hang Bun', 'Hang Dau', 'Hang Than', 'Hoang Dieu', 'Hoang Hoa Tham', 'Hoang Van Thu', 'Hoe Nhai', 'Hong Ha', 'Hong Phuc', 'Hung Vuong', 'Huynh Thuc Khang', 'Khuc Hao', 'Kim Ma', 'Kim Ma Thuong', 'La Thanh', 'Lac Chinh', 'Lang Ha', 'Le Duan', 'Le Hong Phong', 'Le Truc', 'Lieu Giai', 'Linh Lang', 'Ly Nam De', 'Mac Dinh Chi', 'Mai Anh Tuan', 'Nam Cao', 'Nam Trang', 'Nghia Dung', 'Ngoc Ha', 'Ngoc Khanh', 'Ngu Xa', 'Nguyen Bieu', 'Nguyen Canh Chan', 'Nguyen Chi Thanh', 'Nguyen Cong Hoan', 'Nguyen Hong', 'Nguyen Khac Hieu', 'Nguyen Khac Nhu', 'Nguyen Pham Tuan', 'Nguyen Thai Hoc', 'Nguyen Thiep', 'Nguyen Tri Phuong', 'Nguyen Trung Truc', 'Nguyen Truong To', 'Nguyen Van Ngoc', 'Nui Truc', 'Ong Ich Khiem', 'Pham Hong Thai', 'Pham Huy Thong', 'Phan Dinh Phung', 'Phan Huy Ich', 'Phan Ke Binh', 'Pho Duc Chinh', 'Phuc Xa', 'Quan Ngua', 'Quan Thanh', 'Son Tay', 'Tan Ap', 'Thanh Bao', 'Thanh Cong', 'Thanh Nien', 'Ton That Dam', 'Ton That Thiep', 'Tran Huy Lieu', 'Tran Phu', 'Tran Te Xuong', 'Tran Vu', 'Truc Bach', 'Van Bao', 'Van Cao', 'Van Phuc', 'Vinh Phuc', 'Yen Ninh', 'Yen Phu', 'Yen The'];
        $wards_ba_dinh = ['Khuong Thuong', 'Cong Vi', 'Dien Bien', 'Doi Can', 'Giang Vo', 'Kim Ma', 'Lieu Giai', 'Ngoc Ha', 'Ngoc Khanh', 'Nguyen Trung Truc', 'Phuc Xa', 'Quan Thanh', 'Thanh Cong', 'Truc Bach', 'Vinh Phuc'];

        foreach (range(1, 10) as $index) {
            try {
                DB::table('rooms')->insert([
                    'user_id' => rand(1, 100),
                    'price' => rand(100000, 10000000),
                    'area' => rand(10 * 10, 100 * 10) / 10,
                    'decripstion' => $faker->text(150),
                    'image_album_url' => $faker->imageUrl(),
                    'street' => rand(1, 100) . ' ' . $streets_ba_dinh[array_rand($streets_ba_dinh)],
                    'district' => 'Ba Dinh',
                    'ward' => $wards_ba_dinh[array_rand($wards_ba_dinh)],
                    'city' => 'Hanoi',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]);
            } catch (Illuminate\Database\QueryException $e) {

            } catch (PDOException $ee) {

            }

        }

        $streets_hai_ba_truong = ['8-3', 'Ba Trieu', 'Bach Dang', 'Bach Mai', 'Bui Ngoc Duong', 'Bui Thi Xuan', 'Cam Hoi', 'Cao Dat', 'Chua Vua', 'Dai Co Viet', 'Dai La', 'Do Hanh', 'Do Ngoc Du', 'Doan Tran Nghiep', 'Doi Cung', 'Dong Mac', 'Dong Nhan', 'Giai Phong', 'Han Thuyen', 'Hang Chuoi', 'Ho Xuan Huong', 'Hoa Lu', 'Hoa Ma', 'Hoang Mai', 'Hong Mai', 'Hue', 'Huong Vien', 'Kim Nguu', 'Lac Trung', 'Lang Yen', 'Le Dai Hanh', 'Le Duan', 'Le Gia Dinh', 'Le Ngoc Han', 'Le Quy Don', 'Le Thanh Nghi', 'Le Van Huu', 'Lien Tri', 'Lo Duc', 'Luong Yen', 'Mac Thi Buoi', 'Mai Hac De', 'Minh Khai', 'Ngo Thi Nham', 'Nguyen An Ninh', 'Nguyen Binh Khiem', 'Nguyen Cao', 'Nguyen Cong Tru', 'Nguyen Dinh Chieu', 'Nguyen Du', 'Nguyen Hien', 'Nguyen Huy Tu', 'Nguyen Khoai', 'Nguyen Quyen', 'Nguyen Thuong Hien', 'Nguyen Trung Ngan', 'Pham Dinh Ho', 'Phu Dong Thien Vuong', 'Phung Khac Khoan', 'Quang Trung', 'Quynh Loi', 'Quynh Mai', 'Ta Quang Buu', 'Tam Trinh', 'Tang Bat Ho', 'Tay Ket', 'Thai Phien', 'Thanh Nhan', 'The Giao', 'Thi Sach', 'Thien Quang', 'Thinh Yen', 'Tho Lao', 'To Hien Thanh', 'Tran Binh Trong', 'Tran Cao Van', 'Tran Dai Nghia', 'Tran Hung Dao', 'Tran Khanh Du', 'Tran Khat Chan', 'Tran Nhan Tong', 'Tran Thanh Tong', 'Tran Xuan Soan', 'Trieu Viet Vuong', 'Truong Dinh', 'Truong Han Sieu', 'Tue Tinh', 'Tuong Mai', 'Van Don', 'Van Ho', 'Van Kiep', 'Vinh Tuy', 'Vo Thi Sau', 'Vong', 'Vu Huu Loi', 'Yen Bai', 'Yen Lac', 'Yersin', 'Yet Kieu'];
        $wards_hai_ba_truong = ['Khuong Thuong', 'Bach Dang', 'Bach Khoa', 'Bach Mai', 'Bui Thi Xuan', 'Cau Den', 'Dong Mac', 'Dong Nhan', 'Dong Tam', 'Le Dai Hanh', 'Minh Khai', 'Ngo Thi Nham', 'Nguyen Du', 'Pham Dinh Ho', 'Pho Hue', 'Quynh Loi', 'Quynh Mai', 'Thanh Luong', 'Thanh Nhan', 'Truong Dinh', 'Vinh Tuy'];

        foreach (range(1, 10) as $index) {
            try {
                DB::table('rooms')->insert([
                    'user_id' => rand(1, 100),
                    'price' => rand(100000, 10000000),
                    'area' => rand(10 * 10, 100 * 10) / 10,
                    'decripstion' => $faker->text(150),
                    'image_album_url' => $faker->imageUrl(),
                    'street' => rand(1, 100) . ' ' . $streets_hai_ba_truong[array_rand($streets_hai_ba_truong)],
                    'district' => 'Hai Ba Trung',
                    'ward' => $wards_hai_ba_truong[array_rand($wards_hai_ba_truong)],
                    'city' => 'Hanoi',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]);
            } catch (Illuminate\Database\QueryException $e) {

            } catch (PDOException $ee) {

            }

        }
    }
}
