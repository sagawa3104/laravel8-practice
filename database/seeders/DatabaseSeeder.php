<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Product;
use App\Models\Specification;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $faker = Container::getInstance()->make(Generator::class);
        //ユーザー生成
        User::factory()->state([
            'name' => $faker->name(),
            'email' => 'test@example.com',
        ])->create();
        User::factory()->count(1)->unverified()->create();
        $users = User::all();

        //品目生成
        $products = Product::factory()->count(3)->state(new Sequence(function($sequence){
            $num = $sequence->index +1;
            return [
                'name'=> 'product_name'. sprintf('%04d', $num),
                'code'=> 'product_code'. sprintf('%04d', $num),
            ];
        }))->create();

        //部位生成
        $parts = Part::factory()->count(5)->state(new Sequence(function($sequence){
            $num = $sequence->index +1;
            return [
                'name'=> 'part_name'. sprintf('%04d', $num),
                'code'=> 'part_code'. sprintf('%04d', $num),
            ];
        }))->create();

        //品目-部位中間テーブル生成
        $partIds= $parts->pluck('id')->toArray();
        $products->each(function($product) use($partIds){
            $product->parts()->sync($partIds);
        });

        //仕様生成
        $specifications = Specification::factory()->count(5)->state(new Sequence(function($sequence){
            $num = $sequence->index +1;
            return [
                'code'=> 'specification_code'. sprintf('%04d', $num),
                'content'=> 'specification_content'. sprintf('%04d', $num),
            ];
        }))->create();

        //品目-仕様中間テーブル生成
        $specificationIds= $specifications->pluck('id')->toArray();
        $products->each(function($product) use($specificationIds){
            $product->specifications()->sync($specificationIds);
        });
    }
}
