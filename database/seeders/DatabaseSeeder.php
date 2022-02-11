<?php

namespace Database\Seeders;

use App\Models\MappingItem;
use App\Models\Part;
use App\Models\Process;
use App\Models\ProcessPart;
use App\Models\Product;
use App\Models\RecordedProduct;
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

        //工程生成
        $processes = Process::factory()->count(3)->state(new Sequence(function($sequence){
            $num = $sequence->index +1;
            return [
                'name'=> '工程名称'. sprintf('%04d', $num),
                'code'=> 'process_code'. sprintf('%04d', $num),
            ];
        }))->create();

        //品目生成
        $products = Product::factory()->count(3)->state(new Sequence(function($sequence){
            $num = $sequence->index +1;
            return [
                'name'=> '品目名称'. sprintf('%04d', $num),
                'code'=> 'product_code'. sprintf('%04d', $num),
            ];
        }))->create();

        //工程-品目中間テーブル生成
        $productIds= $products->pluck('id')->toArray();
        $clProcesses= $processes->splice(0,2);
        $clProcesses->each(function($process) use($productIds){
            $process->products()->syncWithPivotValues($productIds, [
                'form' => 'MAPPING'
            ]);
        });
        $mpProcesses= $processes->splice(0,2);
        $mpProcesses->each(function($process) use($productIds){
            $process->products()->syncWithPivotValues($productIds, [
                'form' => 'CHECKLIST'
            ]);
        });

        //部位生成
        $parts = Part::factory()->count(5)->state(new Sequence(function($sequence){
            $num = $sequence->index +1;
            return [
                'name'=> '部位名称'. sprintf('%04d', $num),
                'code'=> 'part_code'. sprintf('%04d', $num),
            ];
        }))->create();

        //品目-部位中間テーブル生成
        $partIds= $parts->pluck('id')->toArray();
        $products->each(function($product) use($partIds){
            $product->parts()->sync($partIds);
        });

        //工程-部位中間テーブル生成
        $processes = Process::all();
        $partIds= $parts->pluck('id')->toArray();
        $processes->each(function($process) use($partIds){
            $process->parts()->sync($partIds);
        });

        //マッピング項目生成
        $processParts = ProcessPart::all();
        $processParts->each(function($processPart, $index){
            $mappingItems = MappingItem::factory()->count(3)->for($processPart)->state(new Sequence(function ($sequence) use ($index) {
                $num = ($sequence->index + 1) + $index * 3;
                return [
                    'code' => 'MI_' . sprintf('%04d', $num),
                    'content' => '検査項目' . sprintf('%04d', $num),
                ];
            }))->create();
        });

        //仕様生成
        $specifications = Specification::factory()->count(5)->state(new Sequence(function($sequence){
            $num = $sequence->index +1;
            return [
                'code'=> 'specification_code'. sprintf('%04d', $num),
                'content'=> '仕様内容'. sprintf('%04d', $num),
            ];
        }))->create();

        //品目-仕様中間テーブル生成
        $specificationIds= $specifications->pluck('id')->toArray();
        $products->each(function($product) use($specificationIds){
            $product->specifications()->sync($specificationIds);
        });


        // 生産実績作成
        $products->each(function($product, $index){
            $recordedProducts = RecordedProduct::factory()->count(10)->for($product)->state(new Sequence(function($sequence) use($index){
                $num = ($sequence->index +1)+ $index*10;
                return [
                    'recorded_number'=> 'RN_'. sprintf('%04d', $num),
                ];
            }))->create();

        });
    }
}
